<?php declare(strict_types=1);

namespace Framework312\Router;

use Framework312\Router\Exception as RouterException;
use Framework312\Template\Renderer;
use Symfony\Component\HttpFoundation\Response;

class Route {
    //Base class that all views should extend (to ensure that all views are valid):
    private const VIEW_CLASS = 'Framework312\Router\View\BaseView';
    //Methods of the BaseView class
    private const VIEW_USE_TEMPLATE_FUNC = 'use_template';
    private const VIEW_RENDER_FUNC = 'render';

    //Name of the view that Route will receive as an argument 
    private string $view;

    public function __construct(string|object $class_or_view) {
        //ReflectionClass = PHP feature with built-in functions that gives information about a class:
        $reflect = new \ReflectionClass($class_or_view);
        //Get the name of the view the class receives as an argument:
        $view = $reflect->getName();
        //Throw an error is the received view is not a child of the BaseView class:
        if (!$reflect->isSubclassOf(self::VIEW_CLASS)) {
            throw new RouterException\InvalidViewImplementation($view);
        }
        $this->view = $view;
    }

    //Call methods (get or post) in the view and return a response:
    public function call(Request $request, ?Renderer $engine): Response {
        // Instantiate the view
        $viewInstance = new $this->view();
    
        // Delegate the rendering to the view's render method
        return $viewInstance->render($request);
    }
}

//Router has to register a path and to call a method of a relevant view
class SimpleRouter implements Router {
    private Renderer $engine;

    // Route registry: path => Route object
    private array $routes = [];

    public function __construct(Renderer $engine) {
        $this->engine = $engine;
    }

    // Add a new route
    public function register(string $path, string|object $class_or_view): void {
        $this->routes[$path] = new Route($class_or_view);
    }

    // Handle incoming requests
    public function serve(mixed ...$args): void {
        // Create a Request object (using your custom Request class)
        $request = new Request(...$args);

        // Extract the path from the request
        $path = $request->getPathInfo();

        // Match the path to a registered route
        foreach ($this->routes as $routePath => $route) {
            // Simple matching logic (you can enhance it with regex for dynamic routes)
            if ($routePath === $path) {
                // Call the route and get a response
                $response = $route->call($request, $this->engine);
                $response->send(); // Send the response to the client
                return;
            }
        }

        // If no route matches, return a 404 response
        $response = new Response('404: Oops! Seems that there is no such route.', 404, ['Content-Type' => 'text/plain']);
        $response->send();
    }
}

?>

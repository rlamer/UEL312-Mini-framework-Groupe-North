<?php declare(strict_types=1);

namespace Framework312\Router;

use Framework312\Router\Exception as RouterException;
use Framework312\Template\Renderer;
use Symfony\Component\HttpFoundation\Response;

class Route {
    private const VIEW_CLASS = 'Framework312\Router\View\BaseView';

    private string|object $view;
    private Renderer $renderer;

    public function __construct(string|object $class_or_view, Renderer $renderer) {
        // Reflection to ensure the class is a valid BaseView
        $reflect = new \ReflectionClass($class_or_view);
        $view = $reflect->getName();

        if (!$reflect->isSubclassOf(self::VIEW_CLASS)) {
            throw new RouterException\InvalidViewImplementation($view);
        }

        $this->view = $class_or_view;
        $this->renderer = $renderer;
    }

    public function call(Request $request): Response {
        // Instantiate the view with the renderer
        $viewInstance = is_string($this->view)
            ? new $this->view($this->renderer)
            : $this->view;

        // Delegate rendering to the view's render method
        return $viewInstance->render($request);
    }
}

//Router has to register a path and to call a method of a relevant view
namespace Framework312\Router;

use Framework312\Template\Renderer;

class SimpleRouter implements Router {
    private Renderer $engine;
    private array $routes = [];

    public function __construct(Renderer $engine) {
        $this->engine = $engine;
    }

    public function register(string $path, string|object $class_or_view): void {
        $this->routes[$path] = new Route($class_or_view, $this->engine);
    }

    public function serve(mixed ...$args): void {
        $request = new Request(...$args);
        $path = $request->getPathInfo();

        foreach ($this->routes as $routePath => $route) {
            if ($routePath === $path) {
                $response = $route->call($request);
                $response->send();
                return;
            }
        }

        $response = new \Symfony\Component\HttpFoundation\Response(
            '404: Oops! Seems that there is no such route.',
            404,
            ['Content-Type' => 'text/plain']
        );
        $response->send();
    }
    
}

?>

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
	    // TODO
    }
}

//Router has to register a path and to call a method of a relevant view
class SimpleRouter implements Router {
    //Renderer registers a tag (e.g. user, book...) and renders a template with appropriate data
    private Renderer $engine;

    public function __construct(Renderer $engine) {
        $this->engine = $engine;
        // TODO
    }


    //Add new routes (e.g./book/:id) and define a view whose methods will be used to handle requests to this URL
    public function register(string $path, string|object $class_or_view) {
	    // TODO
    }

    //Check if the are matching routes, call the relavant view's method, return the response
    public function serve(mixed ...$args): void {
	    // TODO
    }
}

?>

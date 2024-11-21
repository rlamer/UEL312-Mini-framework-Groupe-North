<?php declare(strict_types=1);

namespace Framework312\Router;

use Framework312\Template\Renderer;

class SimpleRouter implements Router
{
    private array $routes = [];

    public function __construct(private Renderer $renderer)
    {
    }

    // Enregistrer une route (GET, POST, etc.)
    public function register(string $path, array $handler, string $method = 'GET'): void
    {
        $this->routes[strtoupper($method)][$path] = $handler;
    }

    // Dispatcher la requête en fonction du chemin et de la méthode
    public function dispatch(string $uri): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($uri, PHP_URL_PATH);

        foreach ($this->routes[$method] as $route => $handler) {
            // Utilisation de la regex pour capturer les paramètres dynamiques dans l'URL
            if (preg_match('#^' . preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[0-9]+)', $route) . '$#', $path, $matches)) {
                // Conversion explicite des paramètres en entier
                $handlerParams = [];
                foreach ($matches as $key => $value) {
                    // Si c'est un paramètre numérique, on le convertit en entier
                    if (is_numeric($value)) {
                        $handlerParams[] = (int)$value;  // Conversion en entier
                    } else {
                        $handlerParams[] = $value;
                    }
                }

                [$controller, $action] = $handler;
                $controllerInstance = new $controller($this->renderer);
                $controllerInstance->$action(...$handlerParams);
                return;
            }
        }

        // Si aucune route ne correspond, on sert la page 404
        $this->serve();
    }

    // Méthode pour gérer les erreurs 404
    public function serve(): void
    {
        echo $this->renderer->render('404.twig');
    }
}

<?php declare(strict_types=1);

namespace Framework312\Router;

use Framework312\Template\Renderer;


class SimpleRouter implements Router
{
    private array $routes = [];

    // Le constructeur prend un objet Renderer pour rendre les vues Twig
    public function __construct(private Renderer $renderer)
    {
    }

    // Enregistrer une route (GET, POST, etc.)
    public function register(string $path, array $handler, string $method = 'GET'): void
    {
        // On enregistre la route dans un tableau multidimensionnel
        $this->routes[strtoupper($method)][$path] = $handler;
    }

    // Dispatcher la requête en fonction du chemin et de la méthode
    public function dispatch(string $uri): void
    {
        // On récupère la méthode de la requête HTTP (GET, POST, etc.)
        $method = $_SERVER['REQUEST_METHOD'];
        // On extrait le chemin de l'URL
        $path = parse_url($uri, PHP_URL_PATH);

        // Vérification si la route existe pour la méthode et le chemin
        if (isset($this->routes[$method][$path])) {
            // On récupère le contrôleur et l'action associés à cette route
            $handler = $this->routes[$method][$path];
            [$controller, $action] = $handler;

            // On crée une instance du contrôleur et on exécute l'action
            $controllerInstance = new $controller($this->renderer);
            $controllerInstance->$action();
        } else {
            // Si la route n'existe pas, on appelle la méthode pour gérer l'erreur 404
            $this->serve();
        }
    }

    // Méthode pour gérer les erreurs 404
    public function serve(): void
    {
        // On rend la page 404 via Twig (il faut avoir un template '404.twig')
        echo $this->renderer->render('404.twig');
    }
}

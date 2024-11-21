<?php declare(strict_types=1);

namespace Framework312\Router;

interface Router
{
    // Enregistrer une route
    public function register(string $path, array $handler, string $method = 'GET'): void;

    // Dispatcher la requête
    public function dispatch(string $uri): void;

    // Servir une réponse (par exemple, une page 404 si la route n'est pas trouvée)
    public function serve(): void;
}

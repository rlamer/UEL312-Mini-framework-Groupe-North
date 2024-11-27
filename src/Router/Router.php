<?php declare(strict_types=1);

namespace Framework312\Router;

interface Router {
    //Add new routes (e.g./book/:id) and define a view whose methods will be used to handle requests to this URL
    public function register(string $path, string|object $class_or_view);

    //Check if the are matching routes, call the relavant view's method, return the response
    public function serve(mixed ...$args);
}


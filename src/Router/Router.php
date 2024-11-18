<?php declare(strict_types=1);

namespace Framework312\Router;

interface Router {
    //Add new routes (e.g./book/:id) and define a view whose methods will be used to handle requests to this URL
    public function register(string $path, string|object $class_or_view);

    //Check if the are matching routes, call the relavant view's method, return the response
    public function serve(mixed ...$args);
}

/*
Example View:

class BookView {
    public function get($request) {
        // Logic to retrieve and display a book
        return ['title' => '1984', 'author' => 'George Orwell'];
    }

    public function post($request) {
        // Logic to add a new book
        return ['status' => 'success', 'message' => 'Book added'];
    }
}

Register a route:

$router = new SimpleRouter();

// Register the route for viewing a book
$router->register('/book/:id', BookView::class);

Serve a request:
$router->serve();   - calls the get method of BookView 


**/


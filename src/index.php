<?php

declare(strict_types=1);

// Autoload dependencies and framework classes
require __DIR__ . '/../vendor/autoload.php';


use Framework312\Router\SimpleRouter;
use Framework312\Router\Request; // Your custom Request class
use Framework312\Template\SimpleRenderer;

// Initialize the renderer and router
$renderer = new SimpleRenderer(); // Replace with your actual Renderer implementation
$router = new SimpleRouter($renderer);

// Register routes
$router->register('/home', Framework312\Router\View\HomeView::class);
$router->register('/', Framework312\Router\View\HomeView::class);

// Create a request from global variables
$request = new Request('GET', $_GET, $_POST, $_SERVER);

// Serve the request
$router->serve($request);

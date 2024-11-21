<?php declare(strict_types=1);

use Framework312\Router\SimpleRouter;
use Framework312\Controller\HomeController;  // Ajout de l'importation de HomeController
use Framework312\Controller\ContactController; 
use Framework312\Controller\AccueilController;
use Framework312\Controller\BlogController;
use Framework312\Controller\ArticleController;
use Framework312\Template\Renderer;

// index.php

// index.php

require_once __DIR__ . '/vendor/autoload.php';

// Crée un objet Renderer avec le chemin vers le dossier Template
$renderer = new Renderer(__DIR__ . '/src/template');

// Crée le routeur et passe l'objet Renderer
$router = new SimpleRouter($renderer);

// Enregistre les routes
$router->register('/', [HomeController::class, 'index']);
$router->register('/index.php', [HomeController::class, 'index']);
$router->register('/contact', [ContactController::class, 'index']);
$router->register('/accueil', [AccueilController::class, 'index']);
$router->register('/article', [ArticleController::class, 'show']);
$router->register('/blog', [BlogController::class, 'index']);


// Récupère l'URI de la requête et nettoie pour ne pas inclure /index.php
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

// Déclenche le dispatch de la route
$router->dispatch($requestUri);



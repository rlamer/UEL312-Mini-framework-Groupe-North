<?php declare(strict_types=1);

use Framework312\Router\SimpleRouter;
use Framework312\Router\View\HTMLView;
use Framework312\Router\View\TemplateView;
use Framework312\Template\SimpleRenderer;
use Symfony\Component\HttpFoundation\Request;

// Autoload dependencies (assuming Composer is used)
require_once __DIR__ . '/vendor/autoload.php';

// Initialize the Router
$renderer = new SimpleRenderer(__DIR__ . '/templates');
$router = new SimpleRouter($renderer);

//Sample data
$books = [
    'title' => 'Books List',
    'books' => [
        ['id' => 1, 'title' => '1984', 'author' => 'George Orwell'],
        ['id' => 2, 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee'],
        ['id' => 3, 'title' => 'Pride and Prejudice', 'author' => 'Jane Austen'],
    ]
];

// Define BooksHTML to display books list with plain HTML
class BooksHTML extends HTMLView {
    protected function get(Request $request): string {
        // Check if there are books
        if (empty($this->data)) {
            return '<h1>Book List</h1><p>No books available.</p>';
        }

        // Generate HTML for the books array
        $html = '<h1>' . htmlspecialchars($this->data['title'] ?? 'No Title') . '</h1><ul>';
        foreach ($this->data['books'] as $book) {
            $title = htmlspecialchars($book['title'] ?? 'Unknown Title');
            $author = htmlspecialchars($book['author'] ?? 'Unknown Author');
            $html .= "<li><strong>{$title}</strong> by {$author}</li>";
        }
        $html .= '</ul>';

        return $html;
    }
}

// Register the routes for both views
$router->register('/bookshtml', new BooksHTML($books));

// Register the /books route with TemplateView
$router->register('/books', new TemplateView($renderer, 'books', $books));

// Serve the request
$router->serve();

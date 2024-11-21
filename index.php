<?php declare(strict_types=1);

use Framework312\Router\SimpleRouter;
use Framework312\Router\View\HTMLView;
use Framework312\Router\View\TemplateView;
use Framework312\Template\SimpleRenderer;
use Symfony\Component\HttpFoundation\Request;

// Autoload dependencies (assuming Composer is used)
require_once __DIR__ . '/vendor/autoload.php';

// Initialize the Router
$renderer = new SimpleRenderer(__DIR__ . '\templates');
$router = new SimpleRouter($renderer);
$renderer->register('books');

// Define BooksHTML to display books list with plain HTML
class BooksHTML extends HTMLView {
    private array $books = [];

    public function __construct() {
        // Load books data inside the class
        $booksFile = __DIR__ . '/data/books.json';

        if (file_exists($booksFile)) {
            $booksData = json_decode(file_get_contents($booksFile), true);

            if (json_last_error() === JSON_ERROR_NONE) {
                $this->books = $booksData;
            } else {
                throw new RuntimeException("Invalid JSON in books.json: " . json_last_error_msg());
            }
        } else {
            throw new RuntimeException("books.json file not found at $booksFile");
        }
    }

    protected function get(Request $request): string {
        // Check if there are books
        if (empty($this->books)) {
            return '<h1>Book List</h1><p>No books available.</p>';
        }

        // Generate HTML for the books array
        $html = '<h1>Book List</h1><ul>';
        foreach ($this->books as $book) {
            $title = htmlspecialchars($book['title'] ?? 'Unknown Title');
            $author = htmlspecialchars($book['author'] ?? 'Unknown Author');
            $html .= "<li><strong>{$title}</strong> by {$author}</li>";
        }
        $html .= '</ul>';

        return $html;
    }
}



// Register the routes for both views
$router->register('/bookshtml', new BooksHTML());

// Serve the request
$router->serve();

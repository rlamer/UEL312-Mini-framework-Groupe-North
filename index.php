<?php declare(strict_types=1);

use Framework312\Router\SimpleRouter;
use Framework312\Router\View\HTMLView;
use Framework312\Router\View\JSONView;
use Framework312\Router\View\TemplateView;
use Framework312\Template\SimpleRenderer;
use Framework312\Template\Renderer;
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

$users = [
    'title' => 'User List',
    'users' => [
        ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
        ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
        ['id' => 3, 'name' => 'Emily Johnson', 'email' => 'emily.johnson@example.com'],
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

class BookView extends TemplateView {
    public function __construct(Renderer $renderer, array $data) {
        parent::__construct($renderer, 'books', $data); // 'books' is the template directory
    }
}

class UserView extends TemplateView {
    public function __construct(Renderer $renderer, array $data) {
        parent::__construct($renderer, 'users', $data); // 'users' is the template directory
    }
}

class BooksJSONView extends JSONView {
    public function __construct() {
        $data = [
            'title' => 'Books List',
            'books' => [
                ['id' => 1, 'title' => '1984', 'author' => 'George Orwell'],
                ['id' => 2, 'title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee'],
                ['id' => 3, 'title' => 'Pride and Prejudice', 'author' => 'Jane Austen'],
            ],
        ];
        parent::__construct($data);
    }
}

class UsersJSONView extends JSONView {
    public function __construct() {
        $data = [
            'title' => 'User List',
            'users' => [
                ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@example.com'],
                ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@example.com'],
                ['id' => 3, 'name' => 'Emily Johnson', 'email' => 'emily.johnson@example.com'],
            ],
        ];
        parent::__construct($data);
    }
}
$router->register('/api/books', new BooksJSONView());
$router->register('/api/users', new UsersJSONView());

// Register the routes
$router->register('/bookshtml', new BooksHTML($books));

$router->register('/userstemplate', new UserView($renderer, $users));
$router->register('/bookstemplate', new BookView($renderer, $books));

// Serve the request
$router->serve();

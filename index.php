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

class UsersHTML extends HTMLView {
    protected function get(Request $request): string {
        // Check if there are users
        if (empty($this->data)) {
            return '<h1>User List</h1><p>No users available.</p>';
        }

        // Generate HTML for the users array
        $html = '<h1>' . htmlspecialchars($this->data['title'] ?? 'No Title') . '</h1><ul>';
        foreach ($this->data['users'] as $user) {
            $name = htmlspecialchars($user['name'] ?? 'Unknown Name');
            $email = htmlspecialchars($user['email'] ?? 'Unknown Email');
            $html .= "<li><strong>{$name}</strong> - {$email}</li>";
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

//Register routes
$router->register('/bookshtmlmain', new BooksHTML($books));
$router->register('/usershtmlmain', new UsersHTML($users));
$router->register('/userstemplatemain', new UserView($renderer, $users));
$router->register('/bookstemplatemain', new BookView($renderer, $books));
$router->register('/api/booksmain', new BooksJSONView());
$router->register('/api/usersmain', new UsersJSONView());

// Serve the request
$router->serve();

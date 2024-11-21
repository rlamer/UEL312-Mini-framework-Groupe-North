<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\Response;

class HomeView extends BaseView {
    // Indicates that this view uses a template
    public static function use_template(): bool {
        return true;
    }

    // Renders the response using the home/index.php template
    public function render(Request $request): Response {
        // Example: Data to pass to the template
        $data = [
            'title' => 'Welcome to the Home Page',
            'message' => 'This is a message from HomeView!',
        ];

        // Use the Renderer to render the template
        $renderer = new \Framework312\Template\SimpleRenderer();
        $renderer->register('home'); // Register the home template directory
        $content = $renderer->render($data, 'index.php');

        // Return the rendered content as an HTML response
        return new Response($content, 200, ['Content-Type' => 'text/html']);
    }

    // Override the GET method
    protected function get(Request $request): array {
        return [
            'title' => 'Welcome Home',
            'message' => 'This is the Home route.',
        ];
    }
    
    protected function post(Request $request): array {
        return [
            'title' => 'Home POST',
            'message' => 'You made a POST request.',
        ];
    }
    
}

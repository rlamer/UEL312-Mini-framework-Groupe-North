<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\Response;

class HTMLView extends BaseView {
    /**
     * Indicates that templates are not used in this view.
     */
    public static function use_template(): bool {
        return false;
    }

    /**
     * Renders the response for the given HTTP request.
     */
    public function render(Request $request): Response {
        // Determine the HTTP method and call the appropriate method
        $method = strtolower($request->getMethod());

        // Call the appropriate HTTP method (BaseView will throw an exception if not implemented)
        $content = $this->$method($request);

        // Return a Response with the HTML content
        return new Response(
            $content,
            Response::HTTP_OK,
            ['Content-Type' => 'text/html']
        );
    }
}

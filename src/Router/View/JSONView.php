<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class JSONView extends BaseView {
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
        $method = strtolower($request->getMethod());

        // Call the appropriate HTTP method (BaseView will throw an exception if not implemented)
        $content = $this->$method($request);

        // Ensure the response is in JSON format
        return new JsonResponse(
            $content,
            Response::HTTP_OK,
            ['Content-Type' => 'application/json']
        );
    }

    /**
     * Default GET implementation.
     * Can be overridden by child classes to customize the response.
     */
    protected function get(Request $request): array {
        return [
            'status' => 'success',
            'data' => $this->data,
        ];
    }
}

<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Request;
use Framework312\Template\Renderer;
use Symfony\Component\HttpFoundation\Response;

class TemplateView extends BaseView {
    private Renderer $renderer;
    private string $templateDirectory;

    public function __construct(Renderer $renderer, string $templateDirectory, array $data) {
        $this->renderer = $renderer;
        $this->templateDirectory = $templateDirectory;
        $this->data = $data;
  
        // Register the directory with the renderer
        $this->renderer->register($this->templateDirectory);
    }

    public static function use_template(): bool {
        return true;
    }

    protected function get(Request $request): mixed {
        // Default GET implementation renders the template with data
        return $this->renderer->render($this->data, $this->templateDirectory);
    }

    public function render(Request $request): Response {
        $method = strtolower($request->getMethod());

        $output = $this->$method($request);
        
        return new Response($output, 200, ['Content-Type' => 'text/html']);
    }
}

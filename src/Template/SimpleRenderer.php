<?php

declare(strict_types=1);

namespace Framework312\Template;

class SimpleRenderer implements Renderer {
    private string $baseTemplateDir; // Base directory for templates
    private array $templatePaths = []; // Stores paths for registered tags

    public function __construct(string $baseTemplateDir) {
        // Normalize and store the base directory
        $this->baseTemplateDir = rtrim($baseTemplateDir, '/');
    }

    public function render(mixed $data, string $template): string {
        $templateFile = $this->findTemplate($template);
        if (!$templateFile) {
            throw new \RuntimeException("Oops! Template '$template' not found.");
        }

        if (is_array($data)) {
            extract($data, EXTR_SKIP);
        }

        ob_start();
        include $templateFile;
        return ob_get_clean();
    }

    public function register(string $tag): void {
        $tagPath = $this->baseTemplateDir . '/' . $tag;
        if (!is_dir($tagPath)) {
            throw new \RuntimeException("Template directory not found: $tagPath");
        }

        $this->templatePaths[$tag] = $tagPath;
    }

    private function findTemplate(string $template): ?string {
        foreach ($this->templatePaths as $path) {
            $templateFile = "$path/$template";
            if (file_exists($templateFile)) {
                return $templateFile;
            }
        }

        return null;
    }
}

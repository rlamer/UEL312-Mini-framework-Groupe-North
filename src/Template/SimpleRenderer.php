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

        ob_start();
        // Pass $data directly to the template
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
        // Check if the template exists in the registered paths
        if (!isset($this->templatePaths[$template])) {
            return null;
        }
    
        $templateFile = $this->templatePaths[$template];
    
        // If the path is a directory, default to index.php
        if (is_dir($templateFile)) {
            $templateFile .= '/index.php';
        }
    
        // Check if the file exists
        if (file_exists($templateFile)) {
            return $templateFile;
        }
    
        return null;
    }    
    
}

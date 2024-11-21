<?php

declare(strict_types=1);

namespace Framework312\Template;

class SimpleRenderer implements Renderer {
    private array $templatePaths = []; // Array to store template paths by tag

    /**
     * Renders a template with the given data.
     *
     * @param mixed $data Data to be used in the template.
     * @param string $template The template file name (e.g., 'books.php').
     * @return string The rendered template as a string.
     */
    public function render(mixed $data, string $template): string {
        // Locate the template file
        $templateFile = $this->findTemplate($template);
        if (!$templateFile) {
            throw new \RuntimeException("Oops! Template '$template' not found.");
        }

        // Extract data into variables
        if (is_array($data)) {
            extract($data, EXTR_SKIP); // Prevent overwriting existing variables
        }

        // Start output buffering
        ob_start();
        include $templateFile;
        return ob_get_clean(); // Get the buffered content and clean the buffer
    }

    /**
     * Registers a new template tag.
     *
     * @param string $tag The tag/category for templates (e.g., 'books').
     */
    public function register(string $tag): void {
        $this->templatePaths[$tag] = __DIR__ . '/../../templates/' . $tag;
    }

    /**
     * Finds the template file in registered paths.
     *
     * @param string $template The template file name.
     * @return string|null The full path to the template, or null if not found.
     */
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

<?php declare(strict_types=1);

namespace Framework312\Template;

interface Renderer {
    public function render(mixed $data, string $template): string;

    /**
     * Tag = a category of templates (e.g. 'books', 'users')
     * Add a new tag to an array inside the function
     * We define the path to the template (e.g. books/template.php )
     */
    public function register(string $tag);
}






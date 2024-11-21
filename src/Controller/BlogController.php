<?php declare(strict_types=1);

namespace Framework312\Controller;

use Framework312\Template\Renderer;

class BlogController
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    // Action pour afficher le blog
    public function index(): void
    {
        echo $this->renderer->render('blog.twig');
    }
}

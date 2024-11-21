<?php
namespace Framework312\Controller;

use Framework312\Template\Renderer;

class HomeController
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index(): void
    {
        // Rendre le template home.twig
        echo $this->renderer->render('home.twig');
    }
}


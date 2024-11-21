<?php

namespace Framework312\Controller; // Assure-toi du bon namespace

use Framework312\Template\Renderer;

class ContactController
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function index(): void
    {
        echo $this->renderer->render('contact.twig'); // Assure-toi que contact.twig existe dans ton dossier templates
    }
}

<?php declare(strict_types=1);

namespace Framework312\Controller;

class ArticleController
{
    private $renderer;

    public function __construct($renderer)
    {
        $this->renderer = $renderer;
    }

    public function show(): void
    {
        // Afficher l'article sans paramètre 'id'
        echo $this->renderer->render('article.twig');
    }
}

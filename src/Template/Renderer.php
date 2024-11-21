<?php declare(strict_types=1);


namespace Framework312\Template;

class Renderer
{
    private \Twig\Environment $twig;

    public function __construct(string $templatePath)
    {
        $loader = new \Twig\Loader\FilesystemLoader($templatePath);
        $this->twig = new \Twig\Environment($loader);
    }

    public function render(string $template): string
    {
        // Rend le template avec Twig et retourne le résultat
        return $this->twig->render($template);
    }
}



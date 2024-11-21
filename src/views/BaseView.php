<?php declare(strict_types=1);

namespace Framework312\View;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class BaseView {
    private Environment $twig;

    public function __construct() {
        $loader = new FilesystemLoader(__DIR__ . '/../../templates');
        $this->twig = new Environment($loader);
    }

    public function render(string $template, array $data): void {
        echo $this->twig->render($template, $data);
    }
}

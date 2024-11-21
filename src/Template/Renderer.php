<?php declare(strict_types=1);

namespace Framework312\Template;

class SimpleRenderer implements Renderer {
    private array $templatePaths = [];

    /**
     * Enregistrement du nouveau tag avec son chemin associé.
     * @param string
     */
    public function register(string $tag): void {
        // Associe le tag à un chemin de base (par convention, dans ./templates/)
        $this->templatePaths[$tag] = "./templates/$tag";
    }

    /**
     * Rend un template en injectant les données.
     * @param mixed 
     * @param string 
     * @return string 
     * @throws \Exception 
     */
    public function render(mixed $data, string $template): string {
        // Extraire les données pour les rendre disponibles dans le template
        if (is_array($data)) {
            extract($data);
        }

        // Détermine le chemin complet du template
        $templatePath = $this->resolveTemplatePath($template);

        if (!file_exists($templatePath)) {
            throw new \Exception("Le fichier template '$templatePath' est introuvable.");
        }

        // Capture la sortie du template dans un tampon
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }

    /**
     * Résolution du chemin complet d'un template basé sur les tags enregistrés.
     * @param string 
     * @return string 
     */
    private function resolveTemplatePath(string $template): string {
        
        // Vérifie si le template contient un tag (par exemple 'books/template')
        if (str_contains($template, '/')) {
            [$tag, $templateName] = explode('/', $template, 2);
            if (isset($this->templatePaths[$tag])) {
                return "{$this->templatePaths[$tag]}/$templateName.php";
            }
        }

        // Par défaut, recherche dans ./templates/
        return "./templates/$template.php";
    }
}

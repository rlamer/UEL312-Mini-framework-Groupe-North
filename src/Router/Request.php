<?php declare(strict_types=1);

namespace Framework312\Router;

use Symfony\Component\HttpFoundation\{Request as SymfonyRequest, InputBag};

class Request extends SymfonyRequest {
    private array $context = [];

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], ?string $content = null) {
        // Appel du constructeur parent avec les paramètres nécessaires
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        // Gestion du content-type pour PUT, DELETE, PATCH
        $content_type = $this->headers->get('CONTENT_TYPE', '');
        $method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));

        // Si la requête utilise un contenu url-encodé et un des méthodes de modification
        $is_urlencoded = str_starts_with($content_type, 'application/x-www-form-urlencoded');
        $modification_methods = ['PUT', 'DELETE', 'PATCH'];
        
        if ($is_urlencoded && \in_array($method, $modification_methods, true)) {
            // Analyser manuellement le contenu de la requête
            parse_str($this->getContent(), $data);
            $this->request = new InputBag($data);  // Remplacer les données de la requête par les nouvelles
        }

        // Si des arguments supplémentaires sont passés, on les utilise pour le contexte
        if (func_num_args() > 7) {  // Vérifie si des arguments supplémentaires ont été passés
            $args = array_slice(func_get_args(), 7);  // Récupère uniquement les arguments supplémentaires
            $this->context = array_map('strtolower', $args);  // Ajoute les arguments au contexte
        }
    }

    // Fonction pour récupérer des éléments du contexte
    public function fromContext(string $key): mixed {
        return $this->context[strtolower($key)] ?? null;  // Retourne la valeur en minuscule ou null si non trouvé
    }
}

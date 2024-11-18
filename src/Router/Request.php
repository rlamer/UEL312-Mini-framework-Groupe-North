<?php declare(strict_types=1);

namespace Framework312\Router;

use Symfony\Component\HttpFoundation\{Request as SymfonyRequest, InputBag};

/**
 * Symfony HttpFoundation Request class replaces PHP global variables ($_GET, $_POST...) and functions like echo(), setcookie()...
 * The class is used to handle HTTP requests, for example:
 * Data in the URL: $request->query->get('id')
 * Data sent via POST: $request->request->get('name')
 * Files sent from a form: $request->files->get('file')
 * HTTP method: $request->server->get('REQUEST_METHOD')
 * etc
 * The class Request customizes the Symfony class by adding new features
 */
class Request extends SymfonyRequest {
    //Store any additional information that is not part of the standard HTTP request (for example, user role)
    private array $context = [];

    public function __construct(mixed ...$args) {
        parent::__construct($_GET, $_POST, [], $_COOKIE, $_FILES, $_SERVER);

        $content_type = $this->headers->get('CONTENT_TYPE', '');
        $method = strtoupper($this->server->get('REQUEST_METHOD', 'GET'));


        //Check if the content type is application/x-www-form-urlencoded
        //Encoded URL contains key-value pairs: first-name=Frida&last-name=Kahlo 
        $is_urlencoded = str_starts_with($content_type, 'application/x-www-form-urlencoded');
        $modification_methods = ['PUT', 'DELETE', 'PATCH'];
        if ($is_urlencoded && \in_array($method, $modification_methods, true)) {
            //parse_str is a SymfonyRequest method that parses the raw content of the request body into an array:
            parent::parse_str($this->getContent(), $data);
            //InputBag is a Symfony class with some methods to manage the data easier
            $this->request = new InputBag($data);
        }

        //Leave only strings in the array with arguments
        if (func_num_args() > 0) {
            $args = array_filter($args, 'is_string');
        }
        $this->context = array_map('strtolower', $args);
    }

    public function fromContext(string $key): mixed {
        return $this->context[strtolower($key)] ?? null;
    }
}

?>

<?php declare(strict_types=1);

namespace Framework312\Router\View;

use Framework312\Router\Exception as RouterException;
use Framework312\Router\Request;
use Symfony\Component\HttpFoundation\Response;

//Handles HTTP requests and generates responses
abstract class BaseView {
    /*Protected methods: get, post, patch, put, delete
    If a child class does not override one of these methods and it is called, 
    an exception (HttpMethodNotImplemented) is thrown.
    */
    protected function get(Request $request): mixed {
        throw new RouterException\HttpMethodNotImplemented(static::class, 'GET');
    }

    protected function post(Request $request): mixed {
        throw new RouterException\HttpMethodNotImplemented(static::class, 'POST');
    }

    protected function patch(Request $request): mixed {
        throw new RouterException\HttpMethodNotImplemented(static::class, 'PATCH');
    }

    protected function put(Request $request): mixed {
        throw new RouterException\HttpMethodNotImplemented(static::class, 'PUT');
    }

    protected function delete(Request $request): mixed {
        throw new RouterException\HttpMethodNotImplemented(static::class, 'DELETE');
    }

    //Determines whether a template should be used by the view
    abstract static public function use_template(): bool;

    //Defines how the view generates a response.
    //Response is a Symfony HTTPFoundation class
    abstract public function render(Request $request): Response;
}

?>

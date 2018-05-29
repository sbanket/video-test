<?php

namespace App\Router;

use App\Controller\Controller;
use App\Dto\Route;
use Exception;

/**
 * Class Router
 *
 * @package App\Router
 */
class Router
{
    /**
     * @var array
     */
    private $routes;

    /**
     * Router constructor.
     *
     * @param array $routes
     */
    public function __construct(array $routes)
    {
        $this->routes = $routes;
    }

    public function run()
    {
        $url = $this->getUrl();
        if (empty($url)) {
            throw new Exception('No route matched.', 404);
        }

        $route = $this->getRoute($url);
        if ($route !== null) {
            $controllerClass = $route->getControllerClass();
            if (class_exists($controllerClass)) {
                /** @var Controller $controller */
                $controller = new $controllerClass();
                $action     = $route->getAction() . 'Action';
                if (method_exists($controller, $action)) {
                    $controller->setParams($route->getParams());
                    $controller->$action();
                } else {
                    throw new Exception('Action not found.');
                }
            } else {
                throw new Exception('Controller not found.');
            }
        } else {
            throw new Exception('No route matched.', 404);
        }
    }

    /**
     * @return string
     */
    private function getUrl()
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * @param string $url
     *
     * @return Route|null
     */
    private function getRoute(string $url)
    {
        $matchedRoute = null;
        $queryParams  = parse_url($url, PHP_URL_QUERY);
        $path         = parse_url($url, PHP_URL_PATH);
        $pathElements = explode('/', $path);
        foreach ($this->routes as $route => $attributes) {
            $routeElements = explode('/', $route);
            if(count($pathElements) !== count($routeElements)) {
                continue;
            }

            $routeParams   = [];
            $isMatch       = true;
            foreach ($pathElements as $index => $value) {
                if (!isset($routeElements[$index])) {
                    $isMatch = false;
                    break;
                }

                if (preg_match('#{\w+}#', $routeElements[$index])) {
                    $name               = trim($routeElements[$index], '{}');
                    $routeParams[$name] = $value;
                    continue;
                }

                if ($routeElements[$index] !== $value) {
                    $isMatch = false;
                    break;
                }
            }

            if ($isMatch) {
                $matchedRoute = $this->fillRoute($attributes, $routeParams, $queryParams);
                break;
            }
        }

        return $matchedRoute;
    }

    /**
     * @param array  $attributes
     * @param array  $routeParams
     * @param string $queryParams
     *
     * @return Route
     */
    private function fillRoute(array $attributes, ?array $routeParams, ?string $queryParams): Route
    {
        $matchedRoute = new Route();
        $matchedRoute->setControllerClass($attributes['controller']);
        $matchedRoute->setAction($attributes['action']);
        parse_str($queryParams, $query);
        $params = ['route' => $routeParams, 'query' => $query];
        $matchedRoute->setParams($params);

        return $matchedRoute;
    }
}
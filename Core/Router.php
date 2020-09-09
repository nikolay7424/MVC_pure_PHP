<?php

namespace Core;

/**
 * Class Router
 */
class Router
{
    /**
     * @var array
     * associative array of routes
     */
    protected array $routes = [];

    /**
     * @var array
     * Parameters from the matched route
     */
    protected array $params = [];

    /**
     * @param $route
     * @param $params
     * Add a route to the routing table
     */
    public function add(string $route, array $params = [])
    {
        //convert the route to regular expression: escape forward slashes
        $route = preg_replace('/\//', '\\/', $route);

        //convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-_]+)', $route);

        //convert variables with custom regular expression e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        //add a start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }


    /**
     * @return array
     * Getter for routes
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }

    /**
     * @param $url
     * @return bool
     * Match the route to the routes in the routing table
     * Setting the $params property if the route has been found
     */
    public function match($url) : bool
    {
        /*$regexp ='/^(?P<controller>[a-z-_]+)\/(?P<action>[a-z-_]+)$/';*/
        foreach ($this->routes as $route => $params)
        {
            if(preg_match($route, $url, $matches))
            {
                foreach ($matches as $key => $match)
                {
                    if(is_string($key))
                    {
                        $params[$key] = $match;
                    }
                }
                $this->params = $params;
                return true;
            }
        }
        return false;
    }

    /**
     * @return array
     * Getter for params
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param string $url
     */
    public function dispatch(string $url):void
    {
        $url = $this->removeQueryStringVariables($url);
        if($this->match($url))
        {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            //$controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

            if(class_exists($controller))
            {
                $controllerObject = new $controller($this->params);
                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) {
                    $controllerObject->$action();
                } else {
                    throw new \Exception("Method $action in controller $controller cannot be called directly
                     - remove the Action suffix to call this method");
                }
            }else{
                throw new \Exception("Controller class $controller not found");
            }
        }else{
            throw new \Exception("No route matched", 404);
        }
    }

    /**
     * @param string $string
     * @return string
     */
    protected function convertToStudlyCaps(string $string):string
    {
        return str_replace(
            ' ',
            '',
            ucwords(str_replace('-', ' ', $string))
        );
    }

    /**
     * @param string $string
     * @return string
     */
    protected function convertToCamelCase(string $string):string
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * @param string $url
     * @return string
     */
    public function removeQueryStringVariables(string $url):string
    {
        if($url != '')
        {
            $parts = explode('&', $url, 2);

            if(strpos($parts[0], '=') === false)
            {
                $url = $parts[0];
            }else{
                $url = '';
            }
        }
        return $url;
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params))
        {
            $namespace .= $this->params['namespace'] . '\\';
        }
        return $namespace;
    }
}
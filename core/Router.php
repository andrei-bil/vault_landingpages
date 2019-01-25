<?php

namespace App\Core;

class Router
{
    /**
     * All registered routes.
     *
     * @var array
     */
    public $routes = [
        'GET' => [],
        'POST' => []
    ];

    /**
     * Load a user's routes file.
     *
     * @param string $file
     */
    public static function load($file)
    {
        $router = new static;

        require $file;

        return $router;
    }

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function get($uri, $controller)
    {
        $this->routes['GET'][$uri] = $controller;
    }

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $controller
     */
    public function post($uri, $controller)
    {
        $this->routes['POST'][$uri] = $controller;
    }


public function doRouting(){
    // I used PATH_INFO instead of REQUEST_URI, because the
    // application may not be in the root direcory
    // and we dont want stuff like ?var=value
    $reqUrl = $_SERVER['PATH_INFO'];
    $reqMet = $_SERVER['REQUEST_METHOD'];

    foreach($this->routes as  $route) {
        // convert urls like '/users/:uid/posts/:pid' to regular expression
        $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url'])) . "$@D";
        $matches = Array();
        // check if the current request matches the expression
        if($reqMet == $route['method'] && preg_match($pattern, $reqUrl, $matches)) {
            // remove the first match
            array_shift($matches);
            // call the callback with the matched positions as params
            return call_user_func_array($route['callback'], $matches);
        }
    }
}


    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     */
    public function direct($uri, $requestType)
    {
        echo 'The URL is ' . $uri;
        echo "<br>";

        $matches = Array();


        foreach ($this->routes[$requestType] as $regex => $controller) {

            $pattern = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($regex)) . "$@D";

            if ( preg_match($pattern, $uri, $matches ) ) {
                    echo $pattern;
                    // remove the first match
                    // array_shift($matches);
                    print_r($matches);
                    print_r($this->routes[$requestType][$matches[0]]);
                    return $this->callAction(
                        ...explode('@', $this->routes[$requestType][$uri])
                    );
            }
        }


        // if (array_key_exists($uri, $this->routes[$requestType])) {
        //     return $this->callAction(
        //         ...explode('@', $this->routes[$requestType][$uri])
        //     );
        // }

        throw new Exception('No route defined for this URI.');
    }

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $action
     */
    protected function callAction($controller, $action)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (! method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }

        return $controller->$action();
    }
}

<?php

/**
 * Main class is responsible for controller, method orchestration.
 * Call needed controller, ant its method and in case parameters
 * App Main Class where controllers and views are calling from getting url
 * URL FORMAT - /controller/method/params
 */
class Main
{
    /**
     * Controller that we need to call from APP root
     * @var string
     */
    private $controller = 'Pages';
    /**
     * Method inside a controller that we need
     * @var string
     */
    private $method = 'index';
    /**
     * Parameters for a method
     * @var array|false|string[]|void
     */
    private $params = [];

    /**
     * Gets current controller and method
     */
    public function __construct()
    {
        $url = "";

        if (isset($_GET['url'])) {
            $url_to_trim = rtrim($_GET['url'], '/');
            $url_to_trim = filter_var($url_to_trim, FILTER_SANITIZE_URL);
            $url = explode('/', $url_to_trim);
        }

        if (isset($url[0])) {

            // If controller exists, set as a current controller
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
                $this->controller = ucwords($url[0]);
                unset($url[0]);
            }
        }

        require_once '../app/controllers/' . $this->controller . '.php';

        // Start new controller class
        $this->controller = new $this->controller;


        if (isset($url[1])) {
            // Check if method exists in curr controller
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // If exists get parameters
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }
}

<?php

class App {

    protected $controller = 'login';
    protected $method = 'index';
    protected $special_url = ['apply'];
    protected $params = [];

    public function __construct() {
        if (isset($_SESSION['auth']) && $_SESSION['auth'] == 1) {
            $this->controller = 'home';
        }

        $url = $this->parseUrl();

        if (isset($url[0]) && file_exists('app/controllers/' . $url[0] . '.php')) {
            $this->controller = $url[0];
            $_SESSION['controller'] = $this->controller;

            if (in_array($this->controller, $this->special_url)) {
                $this->method = 'index';
            }
            unset($url[0]);
        }

        require_once 'app/controllers/' . $this->controller . '.php';

        $this->controller = new $this->controller;

        
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            $_SESSION['method'] = $this->method;
            unset($url[1]);
        }

        
        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);
        $uri = trim($uri, '/');
        $url = explode('/', filter_var($uri, FILTER_SANITIZE_URL));
        return $url;
    }
}

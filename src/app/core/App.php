<?php

class App {
    // atribut untuk controller, method, dan parameter default
    protected $controller = 'Profile';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();

        if($this->fileCaseInsensitive('../app/controllers', $url[0] . '.php')) {
            $url[0] = $this->fileCaseInsensitive('../app/controllers', $url[0] . '.php');
            $url[0] = explode('.', $url[0])[0];
            $this->controller = $url[0];
            unset($url[0]);
        } else {
            $this->controller = 'NotFound';
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        if(isset($url[1])) {
            if(method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        if(!empty($url)) {
            $this->params = array_values($url);
        }

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    // method parseURL() untuk memecah url menjadi array
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
        } else {
            $url[0] = $this->controller;
        }
        return $url;
    }

    private function fileCaseInsensitive($dir, $file) {
        $files = scandir($dir);
        $lowercase_files = array_map('strtolower', $files);
        $index = array_search(strtolower($file), $lowercase_files);
        if ($index !== false) {
            return $files[$index];
        }
        return false;
    }
}
<?php

class App {
    // atribut untuk controller, method, dan parameter default
    protected $controller = 'SignIn';
    protected $method = 'index';
    protected $params = [];

    private $user_pages = ['AudioBooks', 'BookDetails', 'Profile'];

    public function __construct()
    {
        $url = $this->parseURL();

        if($this->fileCaseInsensitive('../app/controllers', $url[0] . '.php')) {
            $url[0] = $this->fileCaseInsensitive('../app/controllers', $url[0] . '.php');
            $url[0] = explode('.', $url[0])[0];

//            Change this for testing purpose
           $_SESSION['uid'] = 1;
           $_SESSION['privilege'] = Privilege::Admin;

            $this->controller = $url[0];

            // check if not logged in and try to access other pages
            if(!isset($_SESSION['uid']) && $this->controller != 'SignIn' && $this->controller != 'SignUp') {
                $this->controller = 'SignIn';
            }

            // check if logged in and try to access signin or signup page
            else if(isset($_SESSION['uid']) && ($this->controller == 'SignIn' || $this->controller == 'SignUp')) {
                $this->controller = 'Profile';
            }

            // check if logged in and try to access admin page (for user)
            else if(isset($_SESSION['uid']) && isset($_SESSION['privilege'])) {
                if (!in_array($this->controller, $this->user_pages) && $_SESSION['privilege'] == Privilege::User){ // check if not in array of user allowed
                    $this->controller = 'Forbidden';
                }
            }

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
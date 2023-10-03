<?php

class NotFound extends Controller {
    public function index(){
        $data['title'] = '404 Not Found';
        $this->view('templates/header', $data);
        $this->view('not_found/index');
        $this->view('templates/footer');
    }
}
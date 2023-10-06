<?php

class Forbidden extends Controller {
    public function index(){
        $data['title'] = '403 Forbidden';
        $this->view('templates/header', $data);
        $this->view('forbidden/index');
        $this->view('templates/footer');
    }
}
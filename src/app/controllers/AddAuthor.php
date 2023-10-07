<?php

class AddAuthor extends Controller {
    public function index() {
        $data['title'] = 'Add Author';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('add_author/index');
        $this->view('templates/footer');
    }
}
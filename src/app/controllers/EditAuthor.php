<?php

class EditAuthor extends Controller {
    public function index() {
        $data['title'] = 'Edit Author';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('edit_author/index');
        $this->view('templates/footer');
    }
}
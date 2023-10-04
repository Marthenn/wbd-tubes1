<?php

class AddBook extends Controller {
    public function index() {
        $data['title'] = 'Add Book';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('add_book/index');
        $this->view('templates/footer');
    }
}
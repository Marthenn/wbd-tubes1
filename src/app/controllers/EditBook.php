<?php

class EditBook extends Controller {
    public function index() {
        $data['title'] = 'Edit Book';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('edit_book/index');
        $this->view('templates/footer');
    }
}
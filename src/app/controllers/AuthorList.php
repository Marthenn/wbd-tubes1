<?php

class AuthorList extends Controller {
    public function index()
    {
        $data['title'] = 'Author List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('admin_list/author');
        $this->view('templates/footer');
        $this->view('templates/pagination');
    }
}
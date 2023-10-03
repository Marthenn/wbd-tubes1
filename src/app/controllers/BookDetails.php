<?php

class BookDetails extends Controller{
    public function index()
    {
        $data['title'] = 'Book Details';
        $data['duration'] = 42;
        $this->view('templates/header', $data);
        $this->view('templates/navbar_user');
        $this->view('book_details/index', $data);
        $this->view('templates/footer');
    }
}

<?php

class AudioBooksList extends Controller{
    public function index()
    {
        $data['title'] = 'Audio Books List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_user');
        $this->view('audio_books_list/index');
        $this->view('templates/footer');
    }
}
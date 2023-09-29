<?php

class AudioBooks extends Controller{
    public function index()
    {
        $data['title'] = 'Audio Books';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_user');
        $this->view('audio_books/index');
        $this->view('templates/footer');
    }
}
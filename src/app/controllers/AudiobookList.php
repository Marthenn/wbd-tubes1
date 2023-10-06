<?php

class AudiobookList extends Controller {
    public function index($params = 1)
    {
        $data['title'] = 'Audiobook List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $page = (int) $params;
        $bookModel = $this->model('Book_model');
        $data['books'] = $bookModel->getBookPageAdmin($page);
        var_dump($data['books']);
        $this->view('admin_list/audiobooks', $data);
        $this->view('templates/footer');
    }
}
<?php

class AudiobookList extends Controller {
    public function index()
    {
        $data['title'] = 'Audio Books List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('admin_list/audiobooks');
        $this->view('templates/footer');
    }
}
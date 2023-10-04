<?php

class AdminList extends Controller{
    public function audiobooks()
    {
        $data['title'] = 'Audio Books List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('admin_list/audiobooks');
        $this->view('templates/footer');
    }
    public function author()
    {
        $data['title'] = 'Author List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('admin_list/author');
        $this->view('templates/footer');
    }
    public function user()
    {
        $data['title'] = 'User List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('admin_list/user');
        $this->view('templates/footer');
    }
}
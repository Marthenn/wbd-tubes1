<?php

class UserList extends Controller {
    public function index()
    {
        $data['title'] = 'User List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('admin_list/user');
        $this->view('templates/footer');
    }
}
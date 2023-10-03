<?php

class Profile extends Controller{
    public function index()
    {
        $data['title'] = 'Profile';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_user');
        $this->view('profile/index');
        $this->view('templates/footer');
    }
}
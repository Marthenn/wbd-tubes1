<?php

class Profile extends Controller{
    public function index()
    {
        $data['title'] = 'Profile';
        $this->view('templates/header', $data);
        if($_COOKIE['privilege']){
            $this->view('templates/navbar_admin');
        } else {
            $this->view('templates/navbar_user');
        }
        $this->view('profile/index');
        $this->view('templates/footer');
    }
}
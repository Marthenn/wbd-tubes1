<?php

class SignIn extends Controller{
    public function index()
    {
        $data['title'] = 'Sign In';
        $this->view('templates/header', $data);
        $this->view('sign_in/index');
        $this->view('templates/footer');
    }
}
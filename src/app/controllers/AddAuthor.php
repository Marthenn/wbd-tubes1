<?php

class AddAuthor extends Controller {
    public function index() {
        $data['title'] = 'Add Author';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('add_author/index');
        $this->view('templates/footer');
    }
    public function add() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    if(isset($_POST['name']) && isset($_POST['description'])) {
                    $authorModel = $this->model('Author_model');
                    $authorModel->addAuthor($_POST['name'], $_POST['description']);
                    header("Location: /public/authorlist");
                    exit;
                }
                else {
                    throw new Exception('Missing parameters');
                }
                break;
                default:
                    throw new Exception('Method Not Allowed');
            }
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }
}
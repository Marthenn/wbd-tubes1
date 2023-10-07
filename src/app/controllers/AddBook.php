<?php

class AddBook extends Controller {
    public function index() {
        $data['title'] = 'Add Book';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('add_book/index', $data);
        $this->view('templates/footer');
    }
    
    public function add() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    if(isset($_POST['title']) && isset($_POST['author']) && isset($_POST['rating']) && isset($_POST['category']) && isset($_POST['description'])) {
                    $data = [
                        'title' => $_POST['title'],
                        'author' => $_POST['author'],
                        'rating' => $_POST['rating'],
                        'category' => $_POST['category'],
                        'description' => $_POST['description'],
                        'duration' => 0,
                        'cover_image_directory' => '',
                        'audio_directory' => '',
                    ];
                    $bookModel = $this->model('Book_model');
                    $bookModel->addBook($data);
                    exit;
                    break;
                }
                else {
                    throw new Exception('Missing parameters');
                }
                default:
                    throw new Exception('Method Not Allowed');
            }
        } catch (Exception $e) {
            http_response_code($e->getCode());
            exit;
        }
    }
}

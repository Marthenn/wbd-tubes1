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
                    if(isset($_POST['title']) && isset($_POST['author'])) {
                        $data = [
                            'title' => $_POST['title'],
                            'author' => $_POST['author'],
                            'rating' => 0,
                            'category' => "a",
                            'description' => "a",
                            'duration' => 0,
                            'cover_image_directory' => '',
                            'audio_directory' => '',
                        ];
                        $bookModel = $this->model('Book_model');
                        $bookModel->addBook($data);
                        var_dump($data);
                        header("Location: /public/audiobooklist");
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

<?php

class AudioBooks extends Controller {
    public function index()
    {
        $data['title'] = 'Audio Books';
        $bookModel = $this->model('Book_model');
        $data['books'] = $bookModel->getBookPage(1);
        $data['pages'] = $bookModel->countPage();
        $this->view('templates/header', $data);
        $this->view('templates/navbar_user');
        $this->view('audio_books/index', $data);
        $this->view('templates/pagination', $data);
        $this->view('templates/footer');
    }

    public function fetch($numPage) {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $bookModel = $this->model('Book_model');
                    $maxPages = $bookModel->countPage();
                    if ($numPage > $maxPages) {
                        $numPage = $maxPages;
                    }

                    if ($numPage < 1) {
                        $numPage = 1;
                    }
                    $res = $bookModel->getBookPage($numPage);

                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode($res);
                    exit;
                    break;
                default:
                    throw new Exception('Method Not Allowed', 405);       
            }
        } catch (Exception $e) {
            http_response_code(500);
            exit;
        }
    }
}
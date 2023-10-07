<?php
class AudiobookList extends Controller {
    public function index($page = 1)
    {
        $data['title'] = 'Audiobook List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $page = (int) $page;
        $bookModel = $this->model('Book_model');
        $data['books'] = $bookModel->getBookPageAdmin($page);
        $data['pages'] = $bookModel->countPageAdmin();
        $this->view('admin_list/audiobooks', $data);
        $this->view('templates/pagination', $data);
        $this->view('templates/footer');
    }
    
    public function fetch($page = 1)
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $bookModel = $this->model('Book_model');
                    $maxPages = $bookModel->countPageAdmin();
                    
                    if ($page > $maxPages) {
                        $page = $maxPages;
                    }

                    if ($page < 1) {
                        $page = 1;
                    }
                    
                    $res = $bookModel->getBookPageAdmin($page);

                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode($res);
                    exit;
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

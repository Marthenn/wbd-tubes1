<?php

class AuthorList extends Controller {
    public function index()
    {
        $data['title'] = 'Author List';
        $authorModel = $this->model('Author_model');
        $data['authors'] = $authorModel->getAuthorPage(1);
        $data['pages'] = $authorModel->countPage();
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('admin_list/author', $data);
        $this->view('templates/pagination', $data);
        $this->view('templates/footer');
    }

    public function fetch($page = 1, $filter = null) {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $authorModel = $this->model('Author_model');
                    $maxPages = $authorModel->countPage($filter);
                    
                    if ($page > $maxPages) {
                        $page = $maxPages;
                    }

                    if ($page < 1) {
                        $page = 1;
                    }
                    
                    $authorPage = $authorModel->getAuthorPage($page, $filter);

                    $res = [
                        'authors' => $authorPage,
                        'max_pages' => $maxPages
                    ];

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
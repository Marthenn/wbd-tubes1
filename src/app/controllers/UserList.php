<?php

class UserList extends Controller {
    public function index($page = 1)
    {
        $data['title'] = 'User List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $page = (int) $page;
        $userModel = $this->model('Account_model');
        $data['users'] = $userModel->getUserPage($page);
        $data['pages'] = $userModel->countPage();
        $this->view('admin_list/user', $data);
        $this->view('templates/pagination', $data);
        $this->view('templates/footer');
    }
    public function fetch($page = 1, $filter = null) {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    $accountModel = $this->model('Account_model');
                    $maxPages = $accountModel->countPage();
                    
                    if ($page > $maxPages) {
                        $page = $maxPages;
                    }

                    if ($page < 1) {
                        $page = 1;
                    }
                    
                    $userPage = $accountModel->getUserPage($page, $filter);

                    $res = [
                        'users' => $userPage,
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
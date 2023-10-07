<?php

class EditAuthor extends Controller {
    public function index($aid) {
        $data['title'] = 'Edit Author';
        $data['aid'] = $aid;
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('edit_author/index', $data);
        $this->view('templates/footer');
    }
    public function update() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'PUT':
                    if (!isset($data['aid']) || !isset($data['title']) || !isset($data['description'])) {
                        throw new Exception('Missing parameters', 400);
                    }

                    $authorModel = $this->model('Author_model');
                    $authorModel->updateAuthor(aid, $data['title'], $data['description']);
                    header('Location: public/authorlist');
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
    public function delete($aid) {
        $aid = (int) $aid;
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $authorModel = $this->model('Author_model');
                    $authorModel->deleteAuthor($aid);
                    header('Location: /public/authorlist', true, 204);
                    exit;
                default:
                    http_response_code(405);
                    header('Content-Type: application/json');
                    $responseData = [
                        'message' => 'Invalid request method',
                        'type' => 'danger'
                    ];
                    echo json_encode($responseData);
                    exit;
            }
        } catch (Exception $e){
            http_response_code(500);
            header('Content-Type: application/json');
            $requestData = [
                'message' => $e->getMessage(),
                'type' => 'danger'
            ];
            echo json_encode($requestData);
        }
    }
}
<?php

class EditAuthor extends Controller {
    public function index($aid) {
        $data['title'] = 'Edit Author';
        $data['aid'] = $aid;
        $authorModel = $this->model('Author_model');
        $author = $authorModel->getAuthor($aid);
        $data['name'] = $author['name'];
        $data['description'] = $author['description'];

        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('edit_author/index', $data);
        $this->view('templates/footer');
    }

    public function update($aid){
        $aid = (int) $aid;
        try{
            switch ($_SERVER['REQUEST_METHOD']){
                case 'POST':
                    $authorModel = $this->model('Author_model');
                    $name = $_POST['name'];
                    $description = $_POST['description'];
                    $authorModel->updateAuthor($aid, $name, $description);
                    header('Location: /public/authorlist', true, 204);
                    exit;
                    break;
                default:
                    http_response_code(405);
                    header('Content-Type: application/json');
                    $responseData = [
                        'message' => 'Invalid request method',
                        'type' => 'danger'
                    ];
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
    // public function getAuthor($aid){
    //     $aid = (int) $aid;
    //     try{
    //         switch ($_SERVER['REQUEST_METHOD']){
    //             case 'GET':
    //                 $authorModel = $this->model('Author_model');
    //                 $res = $authorModel->getAuthor($aid);
    //                 if (!$res){
    //                     // response 404 Not Found
    //                     header('Content-Type: application/json', true, 404);
    //                     echo json_encode(['message' => 'Author not found']);
    //                     exit;
    //                 } else {
    //                     // response 200 OK
    //                     header('Content-Type: application/json', true, 200);
    //                     echo json_encode($res);
    //                     exit;
    //                 }
    //                 break;
    //             default:
    //                 throw new Exception('Invalid request method', 405);
    //         }
    //     } catch (Exception $e){
    //         http_response_code(500);
    //         header('Content-Type: application/json');
    //         $requestData = [
    //             'message' => $e->getMessage(),
    //             'type' => 'danger'
    //         ];
    //         echo json_encode($requestData);
    //     }
    // }
}
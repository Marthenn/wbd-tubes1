<?php

class Profile extends Controller{
    public function index()
    {
        $data['title'] = 'Profile';
        $this->view('templates/header', $data);
        if($_COOKIE['privilege']){
            $this->view('templates/navbar_admin');
        } else {
            $this->view('templates/navbar_user');
        }
        $this->view('profile/index');
        $this->view('templates/footer');
    }

    public function getProfile(){
        try{
            switch ($_SERVER['REQUEST_METHOD']){
                case 'GET':
                    $accountModel = $this->model('Account_model');
                    $res = $accountModel->getUser($_COOKIE['uid']);
                    if (!$res){
                        // response 404 Not Found
                        http_response_code(404);
                        header('Content-Type: application/json');
                        echo json_encode(['message' => 'Profile not found']);
                        exit;
                    } else {
                        // response 200 OK
                        http_response_code(200);
                        header('Content-Type: application/json');
                        echo json_encode($res);
                        exit;
                    }
                    break;
                default:
                    throw new Exception('Invalid request method', 405);
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

    public function logout(){
        try{
            switch ($_SERVER['REQUEST_METHOD']){
                case 'POST':
                    $accountModel = $this->model('Account_model');
                    $accountModel->logout();
                    // response 204 No Content
                    http_response_code(204);
                    exit;
                    break;
                default:
                    throw new Exception('Invalid request method', 405);
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

    public function delete(){
        try{
            switch($_SERVER['REQUEST_METHOD']){
                case 'DELETE':
                    $accountModel = $this->model('Account_model');
                    $accountModel->deleteUser($_COOKIE['uid']);
                    // response 204 No Content
                    http_response_code(204);
                    $accountModel->logout();
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
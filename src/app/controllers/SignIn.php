<?php

class SignIn extends Controller{
    public function index()
    {
        $data['title'] = 'Sign In';
        $this->view('templates/header', $data);
        $this->view('sign_in/index');
        $this->view('templates/footer');
    }

    public function login(){
        try{
            switch ($_SERVER['REQUEST_METHOD']){
                case 'POST':
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $accountModel = $this->model('Account_model');
                    $res = $accountModel->login($username, $password);
                    if (!$res){
                        header('Content-Type: application/json');
                        // response 401 Unauthorized
                        http_response_code(401);
                        header('Content-Type: application/json');
                        echo json_encode(['redirect' => BASEURL . '/SignIn']);
                        echo json_encode(['type' => 'danger']);
                        echo json_encode(['message' => 'Invalid username or password']);
                        exit;
                    } else { // move to profile page
                        http_response_code(201);
                        header('Content-Type: application/json');
                        echo json_encode(['redirect' => BASEURL . '/Profile']);
                        exit;
                    }
                    break;
                default:
                    throw new Exception('Invalid request method', 405);
            }
        } catch (Exception $e){
            throw new Exception($e->getMessage(), $e->getCode());
        }
    }
}
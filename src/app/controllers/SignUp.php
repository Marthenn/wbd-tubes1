<?php

class SignUp extends Controller{
    public function index()
    {
        $data['title'] = 'Sign Up';
        $this->view('templates/header', $data);
        $this->view('sign_up/index');
        $this->view('templates/footer');
    }

    public function register(){
        try{
            switch($_SERVER['REQUEST_METHOD']){
                case 'POST':
                    $username = $_POST['username'];
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $accountModel = $this->model('Account_model');
                    $res = $accountModel->register($username, $email, $password);
                    if (!$res){
                        // response 409 Conflict
                        http_response_code(409);
                        header('Content-Type: application/json');
                        $responseData = [
                          'message' => 'Username already exist',
                          'type' => 'danger'
                        ];
                    } else { // move to sign in page
                        http_response_code(201);
                        header('Content-Type: application/json');
                        $responseData = [
                          'message' => 'Account created successfully',
                          'type' => 'success'
                        ];
                    }
                    echo json_encode($responseData);
                    exit;
                default:
                    throw new Exception('Invalid request method', 405);
            }
        } catch (Exception $e){
            http_response_code(500);
            header('Content-Type: application/json');
            $responseData = [
                'message' => $e->getMessage(),
                'type' => 'danger'
            ];
            echo json_encode($responseData);
        }
    }
}
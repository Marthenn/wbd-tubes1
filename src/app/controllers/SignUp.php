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
                        Flasher::setFlash('Username already exist', 'danger');
                        // response 409 Conflict
                        http_response_code(409);
                        header('Content-Type: application/json');
                        echo json_encode(['redirect' => BASEURL . '/SignUp']);
                        exit;
                    } else { // move to sign in page
                        Flasher::setFlash('Account created successfully', 'success');
                        http_response_code(201);
                        header('Content-Type: application/json');
                        echo json_encode(['redirect' => BASEURL . '/SignUp']);
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
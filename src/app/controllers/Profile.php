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
                case 'POST':
                    $accountModel = $this->model('Account_model');
                    $accountModel->deleteUser($_COOKIE['uid']);
                    $accountModel->logout();
                    // response 204 No Content
                    http_response_code(204);
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

    public function update(){
        try{
            switch ($_SERVER['REQUEST_METHOD']){
                case 'POST':
                    $accountModel = $this->model('Account_model');
                    $username = $_POST['username'];
                    $email = $_POST['email'];

                    // upload image to storage
                    var_dump($_FILES);
                    if (isset($_FILES["profile-img-edit"])) {
                        $file = $_FILES['profile-img-edit'];
                        echo 'kontol wbd';
                        echo $file;

                        // file error handling
                        if ($file['error'] == UPLOAD_ERR_OK){
                            // change filename to uid
                            $filename = $_COOKIE['uid'];
                            $fileExt = explode('.', $file['name']);
                            $fileExt = strtolower(end($fileExt));
                            $filename .= '.' . $fileExt;

                            // check if file is image
                            $allowedExt = ['jpg', 'jpeg', 'png'];
                            if (!in_array($fileExt, $allowedExt)){
                                // response 400 Bad Request
                                http_response_code(400);
                                header('Content-Type: application/json');
                                $responseData = [
                                    'message' => 'File must be an image',
                                    'type' => 'danger'
                                ];
                                echo json_encode($responseData);
                                exit;
                            }

                            // if file is larger than 500MB
                            if ($file['size'] > 500000){
                                // response 400 Bad Request
                                http_response_code(400);
                                header('Content-Type: application/json');
                                $responseData = [
                                    'message' => 'File is too large',
                                    'type' => 'danger'
                                ];
                                echo json_encode($responseData);
                                exit;
                            }

                            // upload file to storage
                            $uploadDir = '../storage/profile/';
                            $uploadFile = $uploadDir . $filename;
                            if (!move_uploaded_file($file['tmp_name'], $uploadFile)){
                                // response 400 Bad Request
                                http_response_code(400);
                                header('Content-Type: application/json');
                                $responseData = [
                                    'message' => 'File error',
                                    'type' => 'danger'
                                ];
                                echo json_encode($responseData);
                                exit;
                            }
                        } else { // file error
                            // response 400 Bad Request
                            http_response_code(400);
                            header('Content-Type: application/json');
                            $responseData = [
                                'message' => 'File error',
                                'type' => 'danger'
                            ];
                            echo json_encode($responseData);
                            exit;
                        }
                    }

                    $accountModel->updateUser($_COOKIE['uid'], $username, $email);
                    setcookie("uid", $_COOKIE['uid'], time() + 3600, "/");
                    setcookie("username", $username, time() + 3600, "/");
                    setcookie("privilege", $_COOKIE['privilege'], time() + 3600, "/");
                    // response 204 No Content
                    http_response_code(204);
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
}
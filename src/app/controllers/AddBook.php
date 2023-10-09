<?php

class AddBook extends Controller {
    public function index() {
        $data['title'] = 'Add Book';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('add_book/index', $data);
        $this->view('templates/footer');
    }
    
    public function add() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $title = $_POST['title'];
                    $author = $_POST['author'];
                    $rating = $_POST['rating'];
                    $category = $_POST['category'];
                    $fileCoverDir = null;
                    $fileAudioDir = null;
                    $duration = null;
                    $description = null;
                    if (isset($_POST['description'])) {
                        $description = $_POST['description'];
                    } else {
                        $description = "";
                    }
                    $duration = $_POST['duration'];
                    $fileAudio = $_FILES["audio"];
                    // file error handling
                    if ($fileAudio['error'] == UPLOAD_ERR_OK){
                        // change filename to uid
                        $filename = $_POST['title'];
                        $fileExt = explode('.', $fileAudio['name']);
                        $fileExt = strtolower(end($fileExt));
                        $filename .= '.' . $fileExt;
                        // if file is larger than 500MB
                        if ($fileAudio['size'] > 500000000){
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
                        $uploadDir = '../storage/audio/';
                        $fileAudioDir = '/storage/audio/';
                        $uploadFile = $uploadDir . $filename;
                        $fileAudioDir = $fileAudioDir . $filename;
                        if (!move_uploaded_file($fileAudio['tmp_name'], $uploadFile)){
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
                    if (isset($_FILES["cover"])) {
                        $fileCover = $_FILES["cover"];

                        // file error handling
                        if ($fileCover['error'] == UPLOAD_ERR_OK){
                            // change filename to uid
                            $filename = $_POST['title'];
                            $fileExt = explode('.', $fileCover['name']);
                            $fileExt = strtolower(end($fileExt));
                            $filename .= '.' . $fileExt;

                            // if file is larger than 500MB
                            if ($fileCover['size'] > 500000){
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
                            $uploadDir = '../storage/cover/';
                            $fileCoverDir = '/storage/cover/';
                            $uploadFile = $uploadDir . $filename;
                            $fileCoverDir = $fileCoverDir . $filename;
                            if (!move_uploaded_file($fileCover['tmp_name'], $uploadFile)){
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
                    $updateData = [
                        'title' => $title,
                        'author' => $author,
                        'rating' => $rating,
                        'category' => $category,
                        'description' => $description,
                        'cover_image_directory' => $fileCoverDir,
                        'audio_directory' => $fileAudioDir,
                        'duration' => $duration
                    ];
                    
                    $bookModel = $this->model('Book_model');
                    $bookModel->addBook($updateData);
                    http_response_code(200);
                    header('Content-Type: application/json');
                    if (!$fileCoverDir) {
                        $fileCoverDir = "";
                    }
                    $responseData = [
                        'audioPath' => $fileAudioDir,
                        'coverPath' => $fileCoverDir
                    ];
                    echo json_encode($responseData);
                    exit;
                    break;
                default:
                    throw new Exception('Method Not Allowed');
            }
        } catch (Exception $e) {
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

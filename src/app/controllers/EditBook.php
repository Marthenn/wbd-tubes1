<?php

class EditBook extends Controller {
    public function index($bid) {
        $bookModel = $this->model('Book_model');
        $book = $bookModel->getBookByID($bid);
        $data['title'] = 'Edit Book';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('edit_book/index', $book);
        $this->view('templates/footer');
    }

    public function delete() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $bookModel = $this->model('Book_model');
                    $bookModel->deleteBook($_POST['bid']);
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
                    echo json_encode($responseData);
                    exit;
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

    public function update() {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $bookModel = $this->model('Book_model');
                    $bid = $_POST['bid'];
                    $title = $_POST['title'];
                    $author = $_POST['author'];
                    $rating = $_POST['rating']; // check float or not
                    $category = $_POST['category'];
                    $currBook = $bookModel->getBookByID($bid);
                    // var_dump($currBook);
                    $fileCoverDir = $currBook['cover_image_directory'];
                    $fileAudioDir = $currBook['audio_directory'];
                    if (!$bookModel->isAuthorExist($author)) {
                        // response 400 Bad Request
                        http_response_code(400);
                        header('Content-Type: application/json');
                        $responseData = [
                            'message' => 'Author did not exist',
                            'type' => 'danger'
                        ];
                        echo json_encode($responseData);
                        exit;                        
                    }

                    if (!$bookModel->isCategoryExist($category)) {
                        // response 400 Bad Request
                        http_response_code(400);
                        header('Content-Type: application/json');
                        $responseData = [
                            'message' => 'Category did not exist',
                            'type' => 'danger'
                        ];
                        echo json_encode($responseData);
                        exit;   
                    }
                    
                    
                    $description;
                    if (isset($_POST['description'])) {
                        $description = $_POST['description'];
                    } else {
                        $description = "";
                    }
                    
                    // Check cover image file existence
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

                    // Check cover image file existence
                    if (isset($_FILES["audio"])) {
                        // echo "MASUK WOY";
                        $fileAudio = $_FILES["audio"];
                        var_dump($fileAudio['size']);

                        // file error handling
                        if ($fileAudio['error'] == UPLOAD_ERR_OK){
                            // change filename to uid
                            $filename = $_POST['title'];
                            $fileExt = explode('.', $fileAudio['name']);
                            $fileExt = strtolower(end($fileExt));
                            $filename .= '.' . $fileExt;

                            // if file is larger than 500MB
                            if ($fileAudio['size'] > 50000000){
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
                    }

                    $updateData = [
                        'bid' => $bid,
                        'title' => $title,
                        'author' => $author,
                        'rating' => $rating,
                        'category' => $category,
                        'description' => $description,
                        'cover_image_directory' => $fileCoverDir,
                        'audio_directory' => $fileAudioDir
                    ];

                    $bookModel->editBook($updateData);
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
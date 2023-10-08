<?php

class EditBook extends Controller {
    public function index($bid) {
        $bookModel = $this->model('Book_model');
        $book = $bookModel->getBookByID($bid);
        $book['totalSeconds'] = $this->getTotalSeconds($book['duration']);
        $book['currentTotalSeconds'] = $this->getTotalSeconds($book['curr_duration']);
        $data['title'] = 'Edit Book';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $this->view('edit_book/index', $book);
        $this->view('templates/footer');
    }

    private function getTotalSeconds($time)
    {
        list($hours, $minutes, $seconds) = explode(':', $time);
        $hours = (int)$hours;
        $minutes = (int)$minutes;
        $seconds = (int)$seconds;
        return $hours * 3600 + $minutes * 60 + $seconds;
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
                    $currentBook = $bookModel->getBookByID($bid);
                    $fileCoverDir = null;
                    $fileAudioDir = null;
                    $duration = null;
                    $description = null;

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
                    }

                    $updateData = [
                        'bid' => $bid,
                        'title' => $title,
                        'author' => $author,
                        'rating' => $rating,
                        'category' => $category,
                        'description' => $description,
                        'cover_image_directory' => $fileCoverDir,
                        'audio_directory' => $fileAudioDir,
                        'duration' => $duration
                    ];

                    // var_dump($updateData);

                    $bookModel->editBook($updateData);
                    http_response_code(200);
                    header('Content-Type: application/json');

                    // If null, change to current directory
                    if (!$fileAudioDir) {
                        $fileAudioDir = $currentBook['audio-directory'];
                    }

                    if (!$fileCoverDir) {
                        $fileCoverDir = $currentBook['cover-image-directory'];
                    }

                    $responseData = [
                        'audioPath' => $fileAudioDir,
                        'coverPath' => $fileCoverDir
                    ];
                    echo json_encode($responseData);
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
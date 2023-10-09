<?php

class BookDetails extends Controller{
    
    public function index($bid)
    {
        $data['title'] = 'Book Details';
        
        $bookModel = $this->model('Book_model');
        $book = $bookModel->getBookByID($bid);

        $book['totalSeconds'] = $this->getTotalSeconds($book['duration']);
        $book['currentTotalSeconds'] = $this->getTotalSeconds($book['curr_duration']);
        
        $this->view('templates/header', $data);
        $this->view('templates/navbar_user');
        $this->view('book_details/index', $book);
        $this->view('templates/footer');
    }

    public function updatetime($bid) {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'POST':
                    $bookModel = $this->model('Book_model');
                    $newHistory = [
                        'uid' => $_COOKIE['uid'],
                        'bid' => $bid,
                        'curr_duration' => $_POST['curr_duration']
                    ];
                    $bookModel->addHistory($newHistory);
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

    private function getTotalSeconds($time)
    {
        list($hours, $minutes, $seconds) = explode(':', $time);
        $hours = (int)$hours;
        $minutes = (int)$minutes;
        $seconds = (int)$seconds;
        return $hours * 3600 + $minutes * 60 + $seconds;
    }

    // Get HH:MM:SS string from seconds
    private function getFormattedTime($seconds) {
        $hours = (int)($seconds / 3600);
        $seconds -= $hours * 3600;
        $minutes = (int)($seconds / 60);
        $seconds -= $minutes * 60;
        $seconds = (int)$seconds;

        $hoursString = ($hours < 10) ? "0{$hours}" : "{$hours}";
        $minutesString = ($minutes < 10) ? "0{$minutes}" : "{$minutes}";
        $secondsString = ($seconds < 10) ? "0{$seconds}" : "{$seconds}";
        return "{$hoursString}:{$minutesString}:{$secondsString}";
    }


}

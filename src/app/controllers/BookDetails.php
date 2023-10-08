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

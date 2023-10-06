<?php
class AudiobookList extends Controller {
    public function index($page = 1)
    {
        $data['title'] = 'Audiobook List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $page = (int) $page; // Convert the page parameter to an integer
        $bookModel = $this->model('Book_model');
        $data['books'] = $bookModel->getBookPageAdmin($page);
        $data['pages'] = $bookModel->countPageAdmin();
        $this->view('admin_list/audiobooks', $data);
        $this->view('templates/pagination', $data);
        $this->view('templates/footer');
    }
    
    public function fetch($page)
    {
        $page = (int) $page; // Convert the page parameter to an integer
        // Fetch the data you need for the specified page
        $bookModel = $this->model('Book_model');
        $books = $bookModel->getBookPageAdmin($page);
        
        // You can return JSON data here
        header('Content-Type: application/json');
        echo json_encode(["books" => $books]);
    }
}

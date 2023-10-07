<?php
class AudiobookList extends Controller {
    public function index($page = 1)
    {
        $data['title'] = 'Audiobook List';
        $this->view('templates/header', $data);
        $this->view('templates/navbar_admin');
        $page = (int) $page;
        $bookModel = $this->model('Book_model');
        $data['books'] = $bookModel->getBookPageAdmin($page);
        $data['pages'] = $bookModel->countPageAdmin();
        $this->view('admin_list/audiobooks', $data);
        $this->view('templates/pagination', $data);
        $this->view('templates/footer');
    }
    
    public function fetch($page = 1)
    {
        $page = (int) $page;
        $bookModel = $this->model('Book_model');
        $books = $bookModel->getBookPageAdmin($page);
        header('Content-Type: application/json');
        echo json_encode(["books" => $books]);
    }
}

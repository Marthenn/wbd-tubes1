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
        $data['categories'] = $bookModel->getAllCategories();
        $this->view('admin_list/audiobooks', $data);
        $this->view('templates/pagination', $data);
        $this->view('templates/footer');
    }
    
    public function fetch($page = 1, $filter = null)
    {
        try {
            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    
                    $search = isset($_GET['search']) ? $_GET['search'] : null;
                    $duration = isset($_GET['duration']) ? $_GET['duration'] : null;
                    $category = isset($_GET['category']) ? $_GET['category'] : null;
                    $sort = isset($_GET['sort']) ? $_GET['sort'] : null;

                    if($search !== null){
                        $search = trim($search, "/");
                    }
                    if($duration !== null){
                        $duration = trim($duration, "/");
                    }
                    if($category !== null){
                        $category = trim($category, "/");
                    }
                    if($sort !== null){
                        $sort = trim($sort, "/");
                    }

                    if($duration != NULL) {
                        $duration_min = explode("-", $duration)[0];
                        $duration_max = explode("-", $duration)[1];
                    }
                    else {
                        $duration_min = '00:00:00';
                        $duration_max = '23:59:59';
                    }

                    $filter = [
                        'search' => $search,
                        'duration' => [$duration_min, $duration_max],
                        'category' => $category,
                        'sort' => $sort
                    ];
    
                    // var_dump($filter);
                    $bookModel = $this->model('Book_model');
                    $maxPages = $bookModel->countPageAdmin($filter);
                    
                    if ($page > $maxPages) {
                        $page = $maxPages;
                    }

                    if ($page < 1) {
                        $page = 1;
                    }
                    
                    $bookPage = $bookModel->getBookpageAdmin($page, $filter);

                    $res = [
                        'books' => $bookPage,
                        'max_pages' => $maxPages
                    ];

                    header('Content-Type: application/json');
                    http_response_code(200);
                    echo json_encode($res);
                    exit;
                    break;
                default:
                    throw new Exception('Method Not Allowed');
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            http_response_code(500);
            exit;
        }
    }
}

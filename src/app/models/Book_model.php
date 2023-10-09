<?php

class Book_model {

    private $database;

    public function __construct(){
        $this->database = new Database;
    }

    public function countPage($filter = null) {
        if ($filter == null) {
            $this->database->query("SELECT COUNT(*) FROM book");
            $count = $this->database->single();
            return ceil($count['count'] / 8);
        }
        else {
            try {
                $filtered = false;
                $query = "SELECT COUNT(*) FROM book JOIN author ON book.aid = author.aid JOIN category ON book.cid = category.cid";
        
                if (isset($filter['category'])) {
                    $query .= " WHERE category.name = :category";
                    $filtered = true;
                }
                if (isset($filter['duration'])) {
                    if ($filtered) {
                        $query .= " AND duration BETWEEN :duration_min AND :duration_max";
                    } else {
                        $query .= " WHERE duration BETWEEN :duration_min AND :duration_max";
                        $filtered = true;
                    }
                }
                if (isset($filter['search'])) {
                    if ($filtered) {
                        $query .= " AND (title ILIKE :search OR author.name ILIKE :search)";
                    } else {
                        $query .= " WHERE (title ILIKE :search OR author.name ILIKE :search)";
                        $filtered = true;
                    }
                }
        
                $this->database->query($query);
        
                if (isset($filter['category'])) {
                    $this->database->bind(':category', $filter['category']);
                }
                if (isset($filter['duration'])) {
                    $this->database->bind(':duration_min', $filter['duration'][0]);
                    $this->database->bind(':duration_max', $filter['duration'][1]);
                }
                if (isset($filter['search'])) {
                    $this->database->bind(':search', '%' . $filter['search'] . '%');
                }
        
                $count = $this->database->single();
                return ceil($count['count'] / 8);
                
            } catch (Exception $e) {
                return 0;
            }
        }
    }   


    public function countPageAdmin($filter = null) {
        if ($filter == null) {
            $this->database->query("SELECT COUNT(*) FROM book");
            $count = $this->database->single();
            return ceil($count['count'] / 5);
        }
        else {
            try {
                $filtered = false;
                $query = "SELECT COUNT(*) FROM book JOIN author ON book.aid = author.aid JOIN category ON book.cid = category.cid";
        
                if (isset($filter['category'])) {
                    $query .= " WHERE category.name = :category";
                    $filtered = true;
                }
                if (isset($filter['duration'])) {
                    if ($filtered) {
                        $query .= " AND duration BETWEEN :duration_min AND :duration_max";
                    } else {
                        $query .= " WHERE duration BETWEEN :duration_min AND :duration_max";
                        $filtered = true;
                    }
                }
                if (isset($filter['search'])) {
                    if ($filtered) {
                        $query .= " AND (title ILIKE :search OR author.name ILIKE :search)";
                    } else {
                        $query .= " WHERE (title ILIKE :search OR author.name ILIKE :search)";
                        $filtered = true;
                    }
                }
        
                $this->database->query($query);
        
                if (isset($filter['category'])) {
                    $this->database->bind(':category', $filter['category']);
                }
                if (isset($filter['duration'])) {
                    $this->database->bind(':duration_min', $filter['duration'][0]);
                    $this->database->bind(':duration_max', $filter['duration'][1]);
                }
                if (isset($filter['search'])) {
                    $this->database->bind(':search', '%' . $filter['search'] . '%');
                }
        
                $count = $this->database->single();
                return ceil($count['count'] / 5);
                
            } catch (Exception $e) {
                return 0;
            }
        }
    }


    public function getAllCategories() {
        $this->database->query("SELECT DISTINCT name FROM category");
        return $this->database->resultSet();
    }

    // user version for getBookPage
    public function getBookPage($page, $filter = null){
        $offset = ($page - 1) * 8;

        /**
         * Filter will be key-value pair with possible keys:
         * 1. Category -- singular value
         * 2. Duration -- will be range
         * 3. Sort -- duration (asc/desc), title (asc/desc)
         * 4. Search -- will be string for title or author
         *
         * Implementation will be using multiple layered select query
         * Ineffective but if it works, it works :D
         *
         * Expected outputs for a book will be:
         * 1. Title -- from SQL
         * 2. Author -- from SQL (need join)
         * 3. Rating -- from SQL
         * 4. Duration -- from Audio Files (checked later on)
         * 5. Cover Image Directory -- from SQL
         */

        $filtered = false;

        // base select
        $query = "SELECT bid, title, author.name as author, rating, category.name as category, duration, cover_image_directory, audio_directory FROM book JOIN author ON book.aid = author.aid JOIN category ON book.cid = category.cid";

        if (isset($filter['category'])){
            $query = $query . " WHERE category.name = :category";
            $filtered = true;
        }
        if (isset($filter['duration'])){
            if ($filtered){
                $query = $query . " AND duration BETWEEN :duration_min AND :duration_max";
            } else {
                $query = $query . " WHERE duration BETWEEN :duration_min AND :duration_max";
            }
            $filtered = true;
        }
        if (isset($filter['search'])){
            if ($filtered){
                $query = $query . " AND (title ILIKE :search OR author.name ILIKE :search)";
            } else {
                $query = $query . " WHERE (title ILIKE :search OR author.name ILIKE :search)";
            }
            $filtered = true;
        }
        if (isset($filter['sort'])){
            if ($filter['sort'] == 'duration_asc'){
                $query = $query . " ORDER BY duration ASC";
            } else if ($filter['sort'] == 'duration_desc'){
                $query = $query . " ORDER BY duration DESC";
            } else if ($filter['sort'] == 'title_asc'){
                $query = $query . " ORDER BY title ASC";
            } else if ($filter['sort'] == 'title_desc'){
                $query = $query . " ORDER BY title DESC";
            }
        }

        $query = $query . " LIMIT 8 OFFSET :offset";

        $this->database->query($query);
        if (isset($filter['category'])){
            $this->database->bind('category', $filter['category']);
        }
        if (isset($filter['duration'])){
            $this->database->bind('duration_min', $filter['duration'][0]);
            $this->database->bind('duration_max', $filter['duration'][1]);
        }
        if (isset($filter['search'])){
            $this->database->bind('search', '%' . $filter['search'] . '%');
        }
        $this->database->bind('offset', $offset);
        return $this->database->resultSet();
    }

    public function getBookPageAdmin($page, $filter = null){
        $offset = ($page - 1) * 5;
        $filtered = false;
        $query = "SELECT bid, title, book.description, author.name as author, rating, category.name as category, book.duration FROM book JOIN author ON book.aid = author.aid JOIN category ON book.cid = category.cid";
        if (isset($filter['category'])){
            $query = $query . " WHERE category.name = :category";
            $filtered = true;
        }
        if (isset($filter['duration'])){
            if ($filtered){
                $query = $query . " AND duration BETWEEN :duration_min AND :duration_max";
            } else {
                $query = $query . " WHERE duration BETWEEN :duration_min AND :duration_max";
            }
            $filtered = true;
        }
        if (isset($filter['search'])){
            if ($filtered){
                $query = $query . " AND (title ILIKE :search OR author.name ILIKE :search)";
            } else {
                $query = $query . " WHERE (title ILIKE :search OR author.name ILIKE :search)";
            }
            $filtered = true;
        }
        if (isset($filter['sort'])){
            if ($filter['sort'] == 'duration_asc'){
                $query = $query . " ORDER BY duration ASC";
            } else if ($filter['sort'] == 'duration_desc'){
                $query = $query . " ORDER BY duration DESC";
            } else if ($filter['sort'] == 'title_asc'){
                $query = $query . " ORDER BY title ASC";
            } else if ($filter['sort'] == 'title_desc'){
                $query = $query . " ORDER BY title DESC";
            }
        }

        $query = $query . " LIMIT 5 OFFSET :offset";

        $this->database->query($query);
        if (isset($filter['category'])){
            $this->database->bind(':category', $filter['category']);
        }
        if (isset($filter['duration'])){
            $this->database->bind(':duration_min', $filter['duration'][0]);
            $this->database->bind(':duration_max', $filter['duration'][1]);
        }
        if (isset($filter['search'])){
            $this->database->bind(':search', '%' . $filter['search'] . '%');
        }
        $this->database->bind('offset', $offset);
        return $this->database->resultSet();
    }

    public function editBook($data) {
        /**
         * $data will be key-value pair with keys:
         * 0. bid (book id)
         * 1. Title
         * 2. Author
         * 3. Rating
         * 4. Category (singular)
         * 5. Description
         * 6. Cover Image Directory (nullable)
         * 7. Audio Directory (nullable)
         * 8. Duration (nullable)
         *
         * If cover image and audio directory is null, then it will not be updated
         * If cover image directory value is delete_please, then it will be deleted
         */

        // finding the aid of the author
        $this->database->query("SELECT aid FROM author WHERE name = :author");
        $this->database->bind('author', $data['author']);
        $aid = $this->database->single()['aid'];

        // finding the cid of the category
        $this->database->query("SELECT cid FROM category WHERE name = :category");
        $this->database->bind('category', $data['category']);
        $cid = $this->database->single()['cid'];

        // updating the book
        $query = "UPDATE book SET title = :title, aid = :aid, rating = :rating, cid = :cid, description = :description";
        if ($data['cover_image_directory'] != null){
            if ($data['cover_image_directory'] == 'delete_please'){
                $query = $query . ", cover_image_directory = NULL";
            } else {
                $query = $query . ", cover_image_directory = :cover_image_directory";
            }
        }
        if ($data['audio_directory'] != null){
            $query = $query . ", audio_directory = :audio_directory, duration = :duration";
        }
        $query = $query . " WHERE bid = :bid";

        $this->database->query($query);
        $this->database->bind('title', $data['title']);
        $this->database->bind('aid', $aid);
        $this->database->bind('rating', $data['rating']);
        $this->database->bind('cid', $cid);
        $this->database->bind('description', $data['description']);
        if ($data['cover_image_directory'] != null){
            if ($data['cover_image_directory'] != 'delete_please'){
                $this->database->bind('cover_image_directory', $data['cover_image_directory']);
            }
        }
        if ($data['audio_directory'] != null){
            $this->database->bind('audio_directory', $data['audio_directory']);
            $this->database->bind('duration', $data['duration']);
        }
        $this->database->bind('bid', $data['bid']);

        $this->database->execute();
    }

    public function isAuthorExist($author) {
        $query = "SELECT COUNT(*) FROM author WHERE name = :author";
        $this->database->query($query);
        $this->database->bind(':author', $author);
        $count = $this->database->single()['count'];
        return $count > 0;
    }
    
    public function isCategoryExist($category) {
        $query = "SELECT COUNT(*) FROM category WHERE name = :category";
        $this->database->query($query);
        $this->database->bind(':category', $category);
        $count = $this->database->single()['count'];
        return $count > 0;
    }

    public function addBook($data) {
        // Finding the aid of the author
        
        $aid = null;
        if ($this->isAuthorExist($data['author'])) {
            $this->database->query("SELECT aid FROM author WHERE name = :author");
            $this->database->bind('author', $data['author']);
            $aid = $this->database->single()['aid'];
        } else {
            $this->database->query("INSERT INTO author (name) VALUES (:author) RETURNING aid;");
            $this->database->bind(':author', $data['author']);
            $aid = $this->database->single()['aid'];
        }
    
        // Finding the cid of the category
        $cid = null;
        if ($this->isCategoryExist($data['category'])) {
            $this->database->query("SELECT cid FROM category WHERE name = :category");
            $this->database->bind(':category', $data['category']);
            $cid = $this->database->single()['cid'];
        } else {
            $this->database->query("INSERT INTO category (name) VALUES (:category) RETURNING cid;");
            $this->database->bind(':category', $data['category']);
            $cid = $this->database->single()['cid'];
        }
    
        // Inserting the book record
        $query = "INSERT INTO book (title, aid, rating, cid, description, duration, audio_directory) VALUES (:title, :aid, :rating, :cid, :description, :duration, :audio_directory)";
        if ($data['cover_image_directory'] != null){
            if ($data['cover_image_directory'] == 'delete_please'){
                $query = $query . ", cover_image_directory = NULL";
            } else {
                $query = $query . ", cover_image_directory = :cover_image_directory";
                $this->database->bind('cover_image_directory', $data['cover_image_directory']);
            }
        }

        $this->database->query($query);
        $this->database->bind(':title', $data['title']);
        $this->database->bind(':aid', $aid);
        $this->database->bind(':rating', $data['rating']);
        $this->database->bind(':cid', $cid);
        $this->database->bind(':description', $data['description']);
        $this->database->bind(':duration', $data['duration']);
        $this->database->bind(':audio_directory', $data['audio_directory']);

        $this->database->execute();
    }
    
    public function deleteBook($bid) {
        $this->database->query("DELETE FROM book WHERE bid = :bid");
        $this->database->bind(":bid", $bid);
        $this->database->execute();
    }

    public function getBookByID($bid) {
        $query = "SELECT bid, title, author.name as author, rating, book.description, category.name as category, duration, cover_image_directory, audio_directory FROM book JOIN author ON book.aid = author.aid JOIN category ON book.cid = category.cid WHERE bid = :bid";
        $this->database->query($query);
        $this->database->bind('bid', $bid);
        $data = $this->database->single();

        $query = "SELECT curr_duration FROM history WHERE bid = :bid AND uid = :uid";
        $this->database->query($query);
        $this->database->bind('bid', $bid);
        $this->database->bind('uid', $_COOKIE['uid']);

        if (!$this->database->single()){ //full duration
            $curr_duration = "00:00:00";
        } else {
            $curr_duration = $this->database->single()['curr_duration'];
        }

        $data['curr_duration'] = $curr_duration;

        return $data;
    }

    public function addHistory($data) {
        $query = "SELECT hid FROM history WHERE uid = :uid AND bid = :bid";
        $this->database->query($query);
        $this->database->bind(':uid', $data['uid']);
        $this->database->bind(':bid', $data['bid']);
        if (!$this->database->single()) { // if history not found, insert new history
            $queryInsert = "INSERT INTO history (uid, bid, curr_duration) VALUES (:uid, :bid, :curr_duration)";
            $this->database->query($queryInsert);
            $this->database->bind(':uid', $data['uid']);
            $this->database->bind(':bid', $data['bid']);
            $this->database->bind(':curr_duration', $data['curr_duration']);
            $this->database->execute();
        } else { // if history was found, update history
            $hid = $this->database->single()['hid'];
            $queryUpdate = "UPDATE history SET curr_duration = :curr_duration WHERE hid = :hid";
            $this->database->query($queryUpdate);
            $this->database->bind(':hid', $hid);
            $this->database->bind(':curr_duration', $data['curr_duration']);
            $this->database->execute();
        }
    }
}
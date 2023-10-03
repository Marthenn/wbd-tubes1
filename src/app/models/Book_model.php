<?php

class Book_model {
    private $table = "book";
    private $db;

    public function __construct(){
        $this->db = new Database;
    }

    public function getAllCategories() {
        $this->db->query("SELECT DISTINCT name FROM category");
        return $this->db->resultSet();
    }

    // user version for getBookPage
    public function getBookPage($page, $filter = null){
        $offset = ($page - 1) * 5;

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
        $query = "SELECT title, author.name as author, rating, category.name as category, cover_image_directory, audio_directory FROM book JOIN author ON book.aid = author.aid JOIN category ON book.category_id = category.cid";

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
                $query = $query . " AND (title LIKE :search OR author.name LIKE :search)";
            } else {
                $query = $query . " WHERE (title LIKE :search OR author.name LIKE :search)";
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

        $this->db->query($query);
        if (isset($filter['category'])){
            $this->db->bind('category', $filter['category']);
        }
        if (isset($filter['duration'])){
            $this->db->bind('duration_min', $filter['duration'][0]);
            $this->db->bind('duration_max', $filter['duration'][1]);
        }
        if (isset($filter['search'])){
            $this->db->bind('search', '%' . $filter['search'] . '%');
        }
        $this->db->bind('offset', $offset);
        return $this->db->resultSet();
    }
}
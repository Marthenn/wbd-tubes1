<?php

class Book_model {

    public static function getAllCategories() {
        Database::query("SELECT DISTINCT name FROM category");
        return Database::resultSet();
    }

    // user version for getBookPage
    public static function getBookPage($page, $filter = null){
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
        $query = "SELECT title, author.name as author, rating, category.name as category, cover_image_directory, audio_directory FROM book JOIN author ON book.aid = author.aid JOIN category ON book.cid = category.cid";

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

        $query = $query . " LIMIT 8 OFFSET :offset";

        Database::query($query);
        if (isset($filter['category'])){
            Database::bind('category', $filter['category']);
        }
        if (isset($filter['duration'])){
            Database::bind('duration_min', $filter['duration'][0]);
            Database::bind('duration_max', $filter['duration'][1]);
        }
        if (isset($filter['search'])){
            Database::bind('search', '%' . $filter['search'] . '%');
        }
        Database::bind('offset', $offset);
        return Database::resultSet();
    }

    public static function getBookPageAdmin($page, $filter = null){
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

        Database::query($query);
        if (isset($filter['category'])){
            Database::bind('category', $filter['category']);
        }
        if (isset($filter['duration'])){
            Database::bind('duration_min', $filter['duration'][0]);
            Database::bind('duration_max', $filter['duration'][1]);
        }
        if (isset($filter['search'])){
            Database::bind('search', '%' . $filter['search'] . '%');
        }
        Database::bind('offset', $offset);
        return Database::resultSet();
    }

    public static function editBook($data) {
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
         *
         * If cover image and audio directory is null, then it will not be updated
         * If cover image directory value is delete_please, then it will be deleted
         */

        // finding the aid of the author
        Database::query("SELECT aid FROM author WHERE name = :author");
        Database::bind('author', $data['author']);
        $aid = Database::single()['aid'];

        // finding the cid of the category
        Database::query("SELECT cid FROM category WHERE name = :category");
        Database::bind('category', $data['category']);
        $cid = Database::single()['cid'];

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
            $query = $query . ", audio_directory = :audio_directory";
        }
        $query = $query . " WHERE bid = :bid";

        Database::query($query);
        Database::bind('title', $data['title']);
        Database::bind('aid', $aid);
        Database::bind('rating', $data['rating']);
        Database::bind('cid', $cid);
        Database::bind('description', $data['description']);
        if ($data['cover_image_directory'] != null){
            if ($data['cover_image_directory'] != 'delete_please'){
                Database::bind('cover_image_directory', $data['cover_image_directory']);
            }
        }
        if ($data['audio_directory'] != null){
            Database::bind('audio_directory', $data['audio_directory']);
        }
        Database::bind('bid', $data['bid']);

        Database::execute();
    }

    public static function deleteBook($bid) {
        Database::query("DELETE FROM book WHERE bid = :bid");
        Database::bind(":bid", $bid);
        Database::execute();
    }

    public static function getBookByID($bid) {
        $query = "SELECT bid, title, author.name as author, rating, book.description, category.name as category, duration, cover_image_directory, audio_directory FROM book JOIN author ON book.aid = author.aid JOIN category ON book.cid = category.cid WHERE bid = :bid";
        Database::query($query);
        Database::bind('bid', $bid);
        $data = Database::single();

        $query = "SELECT curr_duration FROM history WHERE bid = :bid AND uid = :uid";
        Database::query($query);
        Database::bind('bid', $bid);
        Database::bind('uid', $_SESSION['uid']);
        $curr_duration = Database::single()['curr_duration'];

        // check if no history, then curr_duration = 0
        if ($curr_duration == null){
            $curr_duration = 0;
        }
        $data->curr_duration = $curr_duration;

        return $data;
    }
}
<?php

class Author_model {

    private $database;

    public function __construct(){
        $this->database = new Database;
    }

    public function countPage(){
        $this->database->query("SELECT COUNT(*) FROM author");
        $count = $this->database->single();
        return ceil($count['count'] / 5);
    }

    public function getAuthorPage($page, $filter = null){
        $offset = ($page - 1) * 5;
        if ($filter == null){
            $this->database->query("SELECT DISTINCT aid, name, description FROM author ORDER BY author.aid DESC LIMIT 5 OFFSET :offset");
        } else { // different query to optimize if there's no filter
            $this->database->query("SELECT DISTINCT author.aid, author.name, author.description FROM author LEFT OUTER JOIN book ON book.aid = author.aid WHERE name LIKE :filter or title LIKE :filter ORDER BY aid DESC LIMIT 5 OFFSET :offset");
            $filter = "%".$filter."%";
            $this->database->bind(":filter", $filter);
        }
        $this->database->bind(":offset", $offset);
        $author_list = $this->database->resultSet();

        // add authored books to each author
        foreach($author_list as $author){
            $this->database->query("SELECT book.title FROM book INNER JOIN author ON book.aid = author.aid WHERE author.aid = :aid");
            $this->database->bind(":aid", $author['aid']);
            $author['books'] = $this->database->resultSet();
        }

        return $author_list;
    }

    public function addAuthor($name, $description){
        $this->database->query("INSERT INTO author (name, description) VALUES (:name, :description)");
        $this->database->bind(":name", $name);
        $this->database->bind(":description", $description);
        $this->database->execute();
    }

    public function deleteAuthor($aid){
        $this->database->query("DELETE FROM author WHERE aid = :aid");
        $this->database->bind(":aid", $aid);
        $this->database->execute();
    }

    public function updateAuthor($aid, $name, $description){
        $this->database->query("UPDATE author SET name = :name, description = :description WHERE aid = :aid");
        $this->database->bind(":aid", $aid);
        $this->database->bind(":name", $name);
        $this->database->bind(":description", $description);
        $this->database->execute();
    }

    public function editAuthor($data) {
        /**
         * $data will be key-value pair with keys:
         * 0. aid (author id)
         * 1. Author Name
         * 2. Description (nullable)
         */
        $query = "UPDATE author SET name = :author";
        
        // Check nullity of description data input 
        if ($data['description'] != null) {
            $query = $query . ", description = :description";
        } else {
            $query = $query . ", description = NULL";
        }
        
        $this->database->query($query);
        $this->database->bind(':author', $data['author']);
        if ($data['description'] != null) {
            $this->database->bind(':description', $data['description']);
        }

        $this->database->execute();
    }
}
<?php

class Author_model {
    private $database;

    public function __construct(){
        $this->database = new Database;
    }

    public function getAuthorPage($page){
        $offset = ($page - 1) * 5;
        $this->database->query("SELECT * FROM author ORDER BY aid DESC LIMIT 5 OFFSET :offset");
        $this->database->bind(":offset", $offset);
        $author_list = $this->database->resultSet();

        // add authored books to each author
        foreach($author_list as $author){
            $this->database->query("SELECT book.title FROM book INNER JOIN author ON book.aid = author.aid WHERE author.aid = :aid");
            $this->database->bind(":aid", $author->aid);
            $author->books = $this->database->resultSet();
        }

        return $author_list;
    }
}
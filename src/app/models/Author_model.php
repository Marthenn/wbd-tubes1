<?php

class Author_model {

    public static function getAuthorPage($page, $filter = null){
        $offset = ($page - 1) * 5;
        if ($filter == null){
            Database::query("SELECT DISTINCT aid, name, description FROM author ORDER BY author.aid DESC LIMIT 5 OFFSET :offset");
        } else { // different query to optimize if there's no filter
            Database::query("SELECT DISTINCT author.aid, author.name, author.description FROM author LEFT OUTER JOIN book ON book.aid = author.aid WHERE name LIKE :filter or title LIKE :filter ORDER BY aid DESC LIMIT 5 OFFSET :offset");
            $filter = "%".$filter."%";
            Database::bind(":filter", $filter);
        }
        Database::bind(":offset", $offset);
        $author_list = Database::resultSet();

        // add authored books to each author
        foreach($author_list as $author){
            Database::query("SELECT book.title FROM book INNER JOIN author ON book.aid = author.aid WHERE author.aid = :aid");
            Database::bind(":aid", $author['aid']);
            $author['books'] = Database::resultSet();
        }

        return $author_list;
    }

    public static function addAuthor($name, $description){
        Database::query("INSERT INTO author (name, description) VALUES (:name, :description)");
        Database::bind(":name", $name);
        Database::bind(":description", $description);
        Database::execute();
    }

    public static function deleteAuthor($aid){
        Database::query("DELETE FROM author WHERE aid = :aid");
        Database::bind(":aid", $aid);
        Database::execute();
    }

    public static function updateAuthor($aid, $name, $description){
        Database::query("UPDATE author SET name = :name, description = :description WHERE aid = :aid");
        Database::bind(":aid", $aid);
        Database::bind(":name", $name);
        Database::bind(":description", $description);
        Database::execute();
    }

    public static function editAuthor($data) {
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
        
        Database::query($query);
        Database::bind(':author', $data['author']);
        if ($data['description'] != null) {
            Database::bind(':description', $data['description']);
        }

        Database::execute();
    }
}
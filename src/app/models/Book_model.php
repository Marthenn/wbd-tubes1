<?php

class Book_model {
    private $table = "book";
    private $db;

    public function __construct(){
        $this->db = new Database;
    }
}
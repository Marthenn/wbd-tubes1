<?php

class Account_model{
    private $database;

    public function __construct(){
        $this->database = new Database;
    }

    public function login($username, $password){
        $password = md5($password);
        $this->database->query("SELECT * FROM account WHERE username = :username AND password = :password");
        $this->database->bind(":username", $username);
        $this->database->bind(":password", $password);

        $user = $this->database->single();

        // TODO: made session if user is not null
    }

    public function register($username, $email, $password){
        $date = date("Y-m-d");
        $is_admin = false;
        $this->database->query("INSERT INTO account (username, email, password, is_admin, joined_date) VALUES (:username, :email, :password, :is_admin, :joined_date)");
        $this->database->bind(":username", $username);
        $this->database->bind(":email", $email);
        $this->database->bind(":password", $password);
        $this->database->bind(":is_admin", $is_admin);
        $this->database->bind(":joined_date", $date);
        $this->database->execute();
    }

    public function getUserPage($page, $filter = null){
        $offset = ($page - 1) * 5;
        if ($filter == null) {
            $this->database->query("SELECT uid, username, email, joined_date, is_admin FROM account ORDER BY uid ASC LIMIT 5 OFFSET :offset");
        }
        if ($filter != null) { // different query to optimize the filter
            $this->database->query("SELECT uid, username, email, joined_date, is_admin FROM account WHERE username LIKE :filter or email LIKE :filter ORDER BY uid ASC LIMIT 5 OFFSET :offset");
            $filter = "%".$filter."%";
            $this->database->bind(":filter", $filter);
        }
        $this->database->bind(":offset", $offset);
        return $this->database->resultSet();
    }
}
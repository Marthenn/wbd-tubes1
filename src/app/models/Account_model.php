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

        if ($user){
            session_start();
            $_SESSION['uid'] = $user['uid'];
            if ($user['is_admin']){
                $_SESSION['privilege'] = Privilege::Admin;
            } else {
                $_SESSION['privilege'] = Privilege::User;
            }

            var_dump($_SESSION);
            return true;
        } else {
            return false;
        }
    }

    private function isUsernameExist($username){
        $this->database->query("SELECT * FROM account WHERE username = :username");
        $this->database->bind(":username", $username);
        $user = $this->database->single();
        return $user != null;
    }

    public function register($username, $email, $password){
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $date = $date->format('Y-m-d');

        if (Account_model::isUsernameExist($username)){
            return false;
        }

        $this->database->query("INSERT INTO account (username, email, password, is_admin, joined_date) VALUES (:username, :email, :password, :is_admin, :joined_date)");
        $this->database->bind(":username", $username);
        $this->database->bind(":email", $email);
        $this->database->bind(":password", $password);
        $this->database->bind(":is_admin", false);
        $this->database->bind(":joined_date", $date);
        $this->database->execute();


        return true;
    }

    public function getUserPage($page, $filter = null){
        $offset = ($page - 1) * 5;
        if ($filter == null) {
            $this->database->query("SELECT uid, username, email, joined_date, is_admin FROM account ORDER BY uid ASC LIMIT 5 OFFSET :offset");
        } else { // different query to optimize the filter
            $this->database->query("SELECT uid, username, email, joined_date, is_admin FROM account WHERE username LIKE :filter or email LIKE :filter ORDER BY uid ASC LIMIT 5 OFFSET :offset");
            $filter = "%".$filter."%";
            $this->database->bind(":filter", $filter);
        }
        $this->database->bind(":offset", $offset);
        return $this->database->resultSet();
    }

    public function logout(){
        session_unset();
        if (session_status() == PHP_SESSION_ACTIVE){
            session_destroy();
        }
        session_start();
    }
}

<?php

class Account_model{

    public static function login($username, $password){
        $password = md5($password);
        Database::query("SELECT * FROM account WHERE username = :username AND password = :password");
        Database::bind(":username", $username);
        Database::bind(":password", $password);

        $user = Database::single();

        if ($user){
            session_start();
            $_SESSION['uid'] = $user['uid'];
            $_SESSION['username'] = $user['username'];
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

    private static function isUsernameExist($username){
        Database::query("SELECT * FROM account WHERE username = :username");
        Database::bind(":username", $username);
        $user = Database::single();
        return $user != null;
    }

    public static function register($username, $email, $password){
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $date = $date->format('Y-m-d');

        if (Account_model::isUsernameExist($username)){
            return false;
        }

        Database::query("INSERT INTO account (username, email, password, is_admin, joined_date) VALUES (:username, :email, :password, :is_admin, :joined_date)");
        Database::bind(":username", $username);
        Database::bind(":email", $email);
        Database::bind(":password", $password);
        Database::bind(":is_admin", false);
        Database::bind(":joined_date", $date);
        Database::execute();

        return true;
    }

    public static function getUserPage($page, $filter = null){
        $offset = ($page - 1) * 5;
        if ($filter == null) {
            Database::query("SELECT uid, username, email, joined_date, is_admin FROM account ORDER BY uid ASC LIMIT 5 OFFSET :offset");
        } else { // different query to optimize the filter
            Database::query("SELECT uid, username, email, joined_date, is_admin FROM account WHERE username LIKE :filter or email LIKE :filter ORDER BY uid ASC LIMIT 5 OFFSET :offset");
            $filter = "%".$filter."%";
            Database::bind(":filter", $filter);
        }
        Database::bind(":offset", $offset);
        return Database::resultSet();
    }

    public static function logout(){
        session_unset();
        if (session_status() == PHP_SESSION_ACTIVE){
            session_destroy();
        }
        session_start();
    }
}
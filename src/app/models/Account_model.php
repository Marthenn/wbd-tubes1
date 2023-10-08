<?php

class Account_model{
    private $database;

    public function __construct(){
        $this->database = new Database;
    }

    public function countPage($filter = null) {
        if ($filter == null) {
            $this->database->query("SELECT COUNT(*) FROM account");
        } else {
            $this->database->query("SELECT uid, username, email, joined_date, is_admin FROM account WHERE username ILIKE :filter or email ILIKE :filter ORDER BY uid ASC LIMIT 5 OFFSET :offset");
            $filter = "%".$filter."%";
            $this->database->bind(":filter", $filter);
        }
        
        $count = $this->database->single();
        return ceil($count['count'] / 5);
    }    

    public function login($username, $password){
        $password = md5($password);
        $this->database->query("SELECT * FROM account WHERE username = :username AND password = :password");
        $this->database->bind(":username", $username);
        $this->database->bind(":password", $password);

        $user = $this->database->single();

        if ($user){
            setcookie("uid", $user['uid'], time() + 3600, "/");
            setcookie("username", $user['username'], time() + 3600, "/");
            $is_admin = $user['is_admin'] ? 1 : 0;
            setcookie("privilege", $is_admin, time() + 3600, "/");
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
            $this->database->query("SELECT uid, username, email, joined_date, is_admin FROM account WHERE username ILIKE :filter or email ILIKE :filter ORDER BY uid ASC LIMIT 5 OFFSET :offset");
            $filter = "%".$filter."%";
            $this->database->bind(":filter", $filter);
        }
        $this->database->bind(":offset", $offset);
        return $this->database->resultSet();
    }

    public function logout(){
        setcookie("uid", "", time() - 36000, "/");
        setcookie("username", "", time() - 36000, "/");
        setcookie("privilege", "", time() - 36000, "/");
    }

    public function getUser($uid) {
        $this->database->query("SELECT * FROM account WHERE uid = :uid");
        $this->database->bind(":uid", $uid);
        $res = $this->database->single();
        if (isset($res['password'])){ // remove password from result for security i guess
            unset($res['password']);
        }
        unset($res['uid']);
        return $res;
    }

    public function updateUser($uid, $username, $email, $profile_picture = null) {
        if ($profile_picture != null){
            $this->database->query("UPDATE account SET username = :username, email = :email, profile_pic_directory = :profile_picture WHERE uid = :uid");
            $this->database->bind(":profile_picture", $profile_picture);
        } else {
            $this->database->query("UPDATE account SET username = :username, email = :email WHERE uid = :uid");
        }
        $this->database->bind(":username", $username);
        $this->database->bind(":email", $email);
        $this->database->bind(":uid", $uid);
        $this->database->execute();
    }

    public function deleteUser($uid){
        $this->database->query("DELETE FROM account WHERE uid = :uid");
        $this->database->bind(":uid", $uid);
        $this->database->execute();
    }

    public function usernameExist($username){
        $this->database->query("SELECT * FROM account WHERE username = :username");
        $this->database->bind(":username", $username);
        $res = $this->database->single();
        return $res != null;
    }
}

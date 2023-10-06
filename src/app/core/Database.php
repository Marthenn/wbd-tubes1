<?php

class Database {
    // get the database connection from the .env file
    private static $host = DB_HOST;
    private static $user = DB_USER;
    private static $pass = DB_PASS;
    private static $dbname = DB_NAME;

    private static $dbh; // database handler
    private static $stmt; // statement

    public static function initialize(){
        $dsn = 'pgsql:host=' . Database::$host . ';dbname=' . Database::$dbname;

        // set PDO options
        $options = [
            PDO::ATTR_PERSISTENT => true, // persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // error reporting
        ];

        // create PDO instance
        try {
            Database::$dbh = new PDO($dsn, Database::$user, Database::$pass, $options);
        } catch(PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function query($query){
        Database::$stmt = Database::$dbh->prepare($query);
    }

    public static function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        Database::$stmt->bindValue($param, $value, $type);
    }

    public static function execute(){
        Database::$stmt->execute();
    }

    /**
     * Return all data from the query
     **/
    public static function resultSet(){
        Database::execute();
        return Database::$stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return a single data from the query
     **/
    public static function single(){
        Database::execute();
        return Database::$stmt->fetch(PDO::FETCH_ASSOC);
    }
}
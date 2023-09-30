<?php

class Database {
    // get the database connection from the .env file
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $dbh; // database handler
    private $stmt; // statement

    public function __construct(){
        $dsn = 'pgsql:host=' . $this->host . ';dbname=' . $this->dbname;

        // set PDO options
        $options = [
            PDO::ATTR_PERSISTENT => true, // persistent connection
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION // error reporting
        ];

        // create PDO instance
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }
}
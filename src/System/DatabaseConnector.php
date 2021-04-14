<?php
namespace Src\System;

use PDO;
use PDOException;

class DatabaseConnector {

    public static PDO $dbConnection;

    public function __construct(){ 
	    $host = $_ENV['DB_HOST'];
        $port = intval( $_ENV['DB_PORT']);
        $db   = $_ENV['DB_SCHEMA'];
        $user = $_ENV['DB_USERNAME'];
        $pass = $_ENV['DB_PASSWORD'];

        try {
            DatabaseConnector::$dbConnection = new PDO(
                "mysql:host=$host;port=$port;charset=utf8mb4;dbname=$db",
                $user,
                $pass
            );
        } catch (PDOException $e) {
            exit($e->getMessage());

        }
    }

}


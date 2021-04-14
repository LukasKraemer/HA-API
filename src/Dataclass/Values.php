<?php


namespace Src\Dataclass;


use Src\System\DatabaseConnector;

class Values
{
    public static function getPermission() :Array{
    $schema = $_ENV['DB_SCHEMA'];
    $statement = DatabaseConnector::$dbConnection->prepare("SELECT * FROM $schema.permission");
        $statement->execute();
       return $statement->fetchAll();
    }
    public static function getState() :Array{
        $schema = $_ENV['DB_SCHEMA'];
        $statement = DatabaseConnector::$dbConnection->prepare("SELECT * FROM $schema.state");
        $statement->execute();
        return $statement->fetchAll();
    }
    public static function getUser() :Array{
        $schema = $_ENV['DB_SCHEMA'];
        $statement = DatabaseConnector::$dbConnection->prepare("SELECT * FROM $schema.user");
        $statement->execute();
        return $statement->fetchAll();
    }
    public static function getlog($limit = 30) :Array{
        $schema = $_ENV['DB_SCHEMA'];
        $statement = DatabaseConnector::$dbConnection->prepare("SELECT * FROM $schema.log limit :limit");
        $statement->execute(['limit'=> $limit]);
        return $statement->fetchAll();
    }

}
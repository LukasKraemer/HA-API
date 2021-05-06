<?php
namespace Src\Gateway;

use PDO;
use Src\System\DatabaseConnector;

class TripsManager
{
    var string $sql;
    var array $data;
    var \PDO $database;
    var $table;

    public function __construct($table){
        $this->database = DatabaseConnector::$dbConnection;
        $this->setTable($table);
    }

    public function getOne($id){
        if(is_numeric($id)){
            $this->sql = 'SELECT * FROM '.$this->table .'WHERE id = :id;';
            $this->data = array("id" =>  intval($id));
           return $this->query();
        }else{
            return "none Nummeric Error";
        }
    }

    public function getAll(){
        $this->sql = 'SELECT * FROM '.$this->table.';';
        $this->data = array();
        return $this->query();
        
    }

       /**
        * @param integer $begin UNIX TIMESTAMP
        * @param integer $end UNIX TIMESTAMP
        */
    public function getAllBerween(int $begin, int $end){
 
        if(is_numeric($begin) && is_numeric($end)){

            if($this->table==$_ENV['table_overview']){
                $dates = Array("fieldname"=> "tag","pattern"=> "y-m-d");
            }elseif($this->table==$_ENV['table_raw']){
                $dates = Array("fieldname"=> "Date", "pattern"=> "y/m/d");
            }

            $this->sql = "SELECT * FROM $this->table WHERE $dates[0] <= :begin_day and ".$dates['fieldname']." <= :end_day ;";
            $this->data = array("begin_day" => date( $dates['pattern'] , intval($begin)), "end_day" =>date($dates['pattern'] , intval($end)));
           return $this->query();
        }else{
            return "Date Error Error";
        }
    }

    function getMissing(): ?array
    {
        $summary = $_ENV['table_overview'];
        $this->sql= "SELECT DISTINCT trip_number +1 
                                    FROM $summary
                                    WHERE trip_number +1 NOT IN (SELECT DISTINCT trip_number FROM $summary);";
        $this->data=array();
        return $this->query();
    }

    /**
     * @return array
     */
    public function getMissingDates(): array
    {
        $missing = $this->getMissing();
        $list = array();
        foreach ($missing as $miss){
            $dates = $this->getDateFromID($miss["trip_number +1"]);
            if( isset( $dates[0])) {
                $list[] = $dates[0]["Date"] . " " . $dates[0]["Time"];
            }else{
                $list[] = "no Date Found for Trip ". $miss['trip_number +1'];
            }
        }
        array_pop($list);
        return $list;
    }

    function getDateFromID($tripID){
        $raw = $_ENV['table_raw'];

        $this->sql= "SELECT Date, Time from $raw where trip_counter = :tripID order by counter asc limit 1";
        $this->data=array('tripID' => $tripID);
        return $this->query();
    }



    function getNumberOfLast(){
        $this->sql= "SELECT trip_number FROM $this->table  order by trip_number desc limit 1;";
        $this->data=array();
        return Intval( $this->query()[0]['trip_number']);
        }

    function setTable($table){
        $allowedTables= Array(
            $_ENV['table_raw'],
            $_ENV['table_overview']
        );

        if(in_array($table,$allowedTables)){
            $this->table=$table;
            return true;
        }else{
            return false;
        }
        
    }

    public function getColumns(){

    }
    private function query($assocs= false){
        $stmt= $this->database->prepare($this->sql);
        if($stmt->execute($this->data)){
                if ($assocs){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            return $stmt->fetchAll();
        }else{
            return null;
        }
    }


}
?>
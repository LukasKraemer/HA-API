<?php
namespace Src\Gateway;


use PDO;
use Src\Formatter\Output;
use Src\System\DatabaseConnector;

class SummaryGateway
{
    private array $whereData;
    private string $whereSQL;
    private $mode;
    private $output;
    private \PDO $database;
    private string $sql;

    public function __construct(string $mode)
    {
        $this-> mode = $mode;
        if(isset($_GET['output'])){
            $this->output = strtolower($_GET['output']);
        }else{
            $this->output = "json";
        }
        $this->whereData = array();
        $this->whereSQL = " Where 1=1 ";
        $this->database= DatabaseConnector::$dbConnection;
        $this->setSQL();
    }

    private function createWhereStatement(){

        if($this->mode=="day"){
            if(isset($_GET['timeBegin'])){
                $this->whereSQL .= "AND date(day) > :start ";
                $this->whereData['start'] =date("Y-m-d", intval($_GET['timeBegin']));;
            }
            if(isset($_GET['timeEnd'])){
                $this->whereSQL .= "AND date(day) < :end ";
                $this->whereData['end'] = date("Y-m-d", intval($_GET['timeEnd']));;
            }
            return;
        }
        if(isset($_GET['timeBegin'])){
            $this->whereSQL .= "AND date(day) > :start ";
            $this->whereData['start'] =date("Y-m-d", intval($_GET['timeBegin']));;
        }
        if(isset($_GET['timeEnd'])){
            $this->whereSQL .= "AND day < :end ";
            $this->whereData['end'] = date("Y-m-d", intval($_GET['timeEnd']));;
        }
        if(isset($_GET['MinLength'])){
            $this->whereSQL .= "AND trip_length > :MinLength ";
            $this->whereData['MinLength'] = intval($_GET['MinLength']);
        }
        if(isset($_GET['MaxLength'])){
            $this->whereSQL .= "AND trip_length < :MaxLength ";
            $this->whereData['MaxLength'] = intval($_GET['MaxLength']);
        }
        if(isset($_GET['MaxTempOutdoor'])){
            $this->whereSQL .= "AND outside_temp < :MaxTempOutdoor ";
            $this->whereData['MaxTempOutdoor'] = intval($_GET['MaxTempOutdoor']);
        }
        if(isset($_GET['MinTempOutdoor'])){
            $this->whereSQL .= "AND outside_temp > :MinTempOutdoor ";
            $this->whereData['MinTempOutdoor'] = intval($_GET['MinTempOutdoor']);
        }
        if(isset($_GET['MinConsumption'])){
            $this->whereSQL .= "AND consumption_average > :MinConsumption ";
            $this->whereData['MinConsumption'] = intval($_GET['MinConsumption']);
        }
        if(isset($_GET['MaxConsumption'])){
            $this->whereSQL .= "AND consumption_average < :MaxConsumption ";
            $this->whereData['MaxConsumption'] = intval($_GET['MaxConsumption']);
        }
        if(isset($_GET['MinDriving'])){
            $this->whereSQL .= "AND driving > :MinDriving ";
            $this->whereData['MinDriving'] = intval($_GET['MinDriving']);
        }
        if(isset($_GET['MaxDriving'])){
            $this->whereSQL .= "AND driving < :MaxDriving ";
            $this->whereData['MaxDriving'] = intval($_GET['MaxDriving']);
        }
    }

    private function setSQL() {
        $this->createWhereStatement();
        if ($this->mode =="day"){
        $this->sql='select
        year(day) as year,
        MONTH(day) as month,
        day(day) as day,
        round(sum(trip_length),3) as "Total driving distance" ,
        round(sum(trip_length_ev), 3) as "Total driving distance eletric" ,
        round(sum(driving)/60, 3) as "drivingtime in hours",
        round(sum(driving_ev) /60 ,3) as "drivingtime electic in hours",
        round(sum(driving_move) /60 ,3) as "drivingtime in movement in hours",
        round(sum(fuel)/1000,3) as "fuel in L",
        round( avg(outside_temp_average) ,3) as "outsidetemp average",
        round(avg(soc_average),3) as "Average battery level",
        round(sum(fuel)/1000*100 / sum(trip_length) ,3) as "Average consumption in L",
        round(avg(ev_proportion),3) as "Electric travel time in percent",
        round(avg(speed_average),3) as "Average speed", 
        round(max(speed_max),3) as "Max speed", 
        round(sum(driving_ev)*100/sum(driving_move), 3) as "movement in percent",
        round(sum(trip_length_ev)* 100/sum(trip_length),3) as "electric movement in percent", 
        round(max(driving_ev),3) as "Max drivingtime electic",
        round(min(outside_temp_average),3) as "Min Outside temp",
        round(avg(outside_temp_average),3) as "average Outside temp",
        round(max(outside_temp_average),3) as "Max Outside temp"
        FROM '. $_ENV['table_overview']. $this->whereSQL . ' 
        group by  year, month, day
        order by date(day);';
    }else if ($this->mode =="month"){
       $this->sql='select
        year(day) as year,
        MONTH(day) as month,
        DAY(day) as day,
        round(sum(trip_length),3) as "Total driving distance" ,
        round(sum(trip_length_ev), 3) as "Total driving distance eletric" ,
        round(sum(driving)/60, 3) as "drivingtime in hours",
        round(sum(driving_ev) /60 ,3) as "drivingtime electic in hours",
        round(sum(driving_move) /60 ,3) as "drivingtime in movement in hours",
        round(sum(fuel)/1000,3) as "fuel in L",
        round( avg(outside_temp_average) ,3) as "outsidetemp average",
        round(avg(soc_average),3) as "Average battery level",
        round(sum(fuel)/1000*100 / sum(trip_length) ,3) as "Average consumption in L",
        round(avg(ev_proportion),3) as "Electric travel time in percent",
        round(avg(speed_average),1) as "Average speed", 
        max(speed_max) as "Max speed", 
        round(sum(driving_ev)*100/sum(driving_move), 3) as "movement in percent",
        round(sum(trip_length_ev)* 100/sum(trip_length),3) as "electric movement in percent", 
        round(max(driving_ev),3) as "Max drivingtime electic",
        round(min(outside_temp_average),3) as "Min Outside temp",
        round(avg(outside_temp_average),3) as "average Outside temp",
        round(max(outside_temp_average),3) as "Max Outside temp"
        FROM '. $_ENV['table_overview']. $this->whereSQL . ' 
        group by year, month
        order by date(day);';
        }
        else if ($this->mode =="trips"){
            $this->sql = "SELECT * FROM " . $_ENV['table_overview'] . " " . $this->whereSQL . " order by date(day) asc";
        } else {
            $this->createWhereStatement();
            $this->sql = "SELECT * FROM " . $_ENV['table_overview'] . " " . $this->whereSQL . " order by date(day) asc";
        }
}

    public function getSummary()
    {
        if(strtolower($this->output) != "csv"){
            return $this->query();
        }else{
            Output::genCSV($this->query());
        }
    }

    public function getColumns(): array
    {
        $stmt= $this->database->prepare($this->sql);
        $stmt->execute($this->whereData);
        return  array_keys($stmt->fetch(PDO::FETCH_ASSOC));
    }

    private function query(): ?array
    {
        $stmt= $this->database->prepare($this->sql);
        if($stmt->execute($this->whereData)){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
    }

}
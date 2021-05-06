<?php
/**
*
* API For Ha-Tool
*
* @version 2.0
* @author Lukas Krämer <kontakt@lukas-kraemer.de>
*/
require __DIR__."/bootstrap.php";
use Src\Formatter\Output;
use Src\Gateway\FileManager;
use Src\Gateway\TripsManager;
use Src\Auth;

$methode = $_SERVER['REQUEST_METHOD'];
$allowed = Array('app', 'tool', 'admin', "summary", "gentoken", "login");
$tripmanager = new TripsManager($_ENV['table_overview']);

if(isset($_GET['_url'])){
    //output array
    $output= new Output("application/json");

    //prepare
    $uri= explode("/",$_GET['_url']);
    if(! in_array( strtolower( $uri[1] ) , $allowed)){
        http_response_code(400);
        exit();
    }

    if( strtolower($uri[1])== "gentoken") {
        $data = new Auth();
        $output->addData( $data->genToken(), "accessToken");
        $output->addData($data->login(),"permission");
        $output->print();
        exit();
    }
    if( strtolower($uri[1])== "login") {
        $output->addData( ($data =(new Auth())->login()), "permission");
        $output->print();
        exit();
    }
    try{
        $session=new Auth();
        $permission= $session->login();
        $output->addData($session->getuserData(),'session');
    }catch (Exception $e){
        http_response_code(410);
        exit();
    }

    if( strtolower($uri[1])== "app"){
        //APP API Functions
        if( strtolower($uri[2])== "filename" && $methode == "GET" && $permission >=2)
        {
            $output->addData(FileManager::getFilename(), 'filename');

        }elseif(strtolower($uri[2])== "reader" && $methode == "GET" && $permission >=2){
            $output->addData(FileManager::countTripFiles(), "filesStorage");
            $output->addData($tripmanager->getNumberOfLast(), "databaseLast");

        }elseif(strtolower($uri[2])== "missing" && $methode == "GET" && $permission >=2){
            $missing = $tripmanager->getMissingDates();
            $output->addData($missing, "missing");
        }
        elseif(strtolower($uri[2])== "filename" && $methode == "POST" && $permission >=4){
            FileManager::UploadTrip();

        }elseif(strtolower($uri[2])== "start" && $methode == "GET"  && $permission >=3) {
            $output->addData(FileManager::StartProgram(), "shell");
        }
        elseif(strtolower($uri[2])== "gettxt" && $methode == "GET"  && $permission >=4) {
            FileManager::sendTxt($uri[3]);
        }


    }elseif(strtolower($uri[1])== "admin"){
        echo "admin";

    }elseif(strtolower($uri[1])== "summary"){

        if(strtolower($uri[2]) == "day"){
            $summary = new \Src\Gateway\SummaryGateway("day");
            if(strtolower($uri[3]) == "data"){
                $output->addData($summary->getSummary() , "summary");
            }else{
                $output->addData($summary->getColumns() , "columns");
            }
        }elseif (strtolower($uri[2] = "trip")){
            $summary = new \Src\Gateway\SummaryGateway("trip");
            if(strtolower($uri[3]) == "data"){
                $output->addData($summary->getSummary() , "summary");
            }else{
                $output->addData($summary->getColumns() , "columns");
            }
        }
    }
    $output->print();
}else{
    include "./html/index.html";
}


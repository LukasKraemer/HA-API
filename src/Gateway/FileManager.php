<?php
namespace Src\Gateway;

use Exception;

class FileManager
{

    static function sendTxt(string $requestname): void{
        $path= $_ENV['PathToTripData']. "archive/". $requestname;
        // output headers so that the file is downloaded rather than displayed
        header("Content-type: text/csv");
        header("Content-disposition: attachment; filename = $requestname");
        //readfile($path);
        $csvFile = file($path);
        $data = [];
        foreach ($csvFile as $line) {
            $data[] =  str_getcsv($line, "\t");
        }

        $output = fopen('php://output', 'w');
        foreach ($data as $row){
            fputcsv($output, $row);
        }
        exit();
        }




    static function countTripFiles(): int
    {
        $PathToTripData= $_ENV['PathToTripData'];
        $path =$PathToTripData. "archive";
        $re = '/Trip_[A-Za-z0-9_]*.txt/m';
        $archive=0;
        $readyToCalc=0;

        //scan archive
        $files = scandir($path);
        foreach ($files as $data){
            if(!preg_match_all($re, $data, $matches, PREG_SET_ORDER)!=False){
                $archive++;
            }
        }
        //scan Upload
        $files = scandir($PathToTripData);
        foreach ($files as $data){
            if(!preg_match_all($re, $data, $matches, PREG_SET_ORDER)!=False){
                $readyToCalc++;
            }
        }
        return $archive + $readyToCalc;
    }

    static function getFilename(): array
    {
        $filesArchive = array_slice(scandir($_ENV['PathToTripData']."archive"), 2); //return all Files in archive
        $filesRoot = array_slice(scandir($_ENV['PathToTripData']), 3);
        if(count($filesArchive) != 0){
            return array_merge($filesArchive, $filesRoot);
        }else{
            return $filesArchive;
        }
    }

    static function UploadTrip(): bool
    {
        $file=$_FILES['txtFile'];
        try {
            if(preg_match_all("/Trip_20[1-3][0-9]-[0-2][0-9]-[0-3][0-9]_[0-3][0-9]-[0-9][0-9]-[0-9][0-9].txt/m", $file['name'], $matches, PREG_SET_ORDER)){
                $target_path = $_ENV['PathToTripData'] . basename( $file['name']);
                move_uploaded_file($file['tmp_name'], $target_path);
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }
    static function StartProgram(): string
    {
        $pathTopy = $_SERVER['DOCUMENT_ROOT'];
        $command = "python3 ". $pathTopy."/".$_ENV['Pyname']; // shell command
        $output = shell_exec($command);
        return "$output";
    }


}

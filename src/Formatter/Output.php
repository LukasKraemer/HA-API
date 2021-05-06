<?php
namespace Src\Formatter;

class Output
{
    private $target;
    private $outputarr = Array();

    public function __construct(string $target){
        $this->target = $target;
    }

    public function addData($data, $fieldname=null, $overwrite=false){
        if($fieldname != null){

            if(!isset($this->outputarr[$fieldname]) or $overwrite){
                $this->outputarr[$fieldname]= $data;
                return true;
            }else{
                return false;
            }
            
        }else{
            $this->outputarr[]= $data;
            return true;
        }
    }

    public function print(){
        if($this->target=="application/json"){
            header('Content-Type: application/json');
            echo json_encode($this->outputarr);
        }elseif($this->target == "application/xml"){
            header('Content-Type: application/xml; charset=utf-8');
            $xml = new \SimpleXMLElement($this->outputarr);
            echo $xml->asXML();
        }elseif($this->target == "text/html"){
            header('Content-Type: text/html; charset=utf-8');
            echo $this->outputarr;
        }else{
            header('Content-Type: text/plain; charset=utf-8');
            echo $this->outputarr;
        }

    }

    public static function genCSV($data, $requestname = "export.csv") {
        header("Content-type: text/csv");
        header("Content-disposition: attachment; filename = $requestname");

        $output = fopen('php://output', 'w');

        fputcsv($output, array_keys($data[0]));

        foreach ($data as $row){
            fputcsv($output, $row);
        }
        exit();

    }
}

?>
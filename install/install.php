<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dns=$_POST['dbip'];
$user= $_POST['dbuser'];
$password = $_POST['dbpwd'];
$dbname= $_POST['dbname'];

try{
    $pdo = new pdo( "mysql:host=$dns:3306;dbname=$dbname",
        $user,
        $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $pdo->exec("CREATE SCHEMA IF NOT EXISTS ".$_POST['dbname']."; use ".$_POST['dbname']);
        $pdo->exec(file_get_contents('install.sql'));
        $statement = $pdo->prepare("INSERT INTO user (name, passwd, permission, state_id) VALUES (?, ?, ?, ?)");
        $statement->execute(array($_POST['apiuser'],hash($_POST['hashalgo'], $_POST['apipwd']), 10, 1));


}
catch(PDOException $ex){
    echo($ex);
    die('Unable to connect');
}
$env=array();
$env[]= "#auto generatted";
$env[]="DB_HOST=".$_POST['dbip'];
$env[]= "DB_USERNAME=".$_POST['dbuser'];
$env[]= "DB_PASSWORD=".$_POST['dbpwd'];
$env[]= "DB_SCHEMA=". $_POST['dbname'];
$env[]= "DB_PORT=3306";

$env[]= "#Tabellennamen der DB";
$env[]= "table_user=user";
$env[]= "table_raw=fast_log";
$env[]= "table_overview=overview";
$env[]= "table_list_trips=loggedtrips";
$env[]= "table_api_logger=log";

if(isset($_POST['jwtsecret'])&& strlen($_POST['jwtsecret']) == 64){
    $env[]= "JWT_SECRET=".$_POST['jwtsecret'];
}else{
    $env[]= "JWT_SECRET=".bin2hex(random_bytes(32));
}
$env[]= "hashalgo=".$_POST['hashalgo'];

if(isset($_POST['debug'])){
    $env[]= "debug=true";
}else{
    $env[]= "debug=false";
}

if(isset($_POST['logs'])){
    $env[]= "api_logger=true";
}else{
    $env[]= "api_logger=false";
}

$env[]= "tokenscheck=true";

$env[]= "PathToTripData=".$_POST['pathtripdata'];
$env[]= "PathToPy=".$_POST['pathtpython'];
$env[]= "Pyname=".$_POST['filenamepy'];
$env[]= "process=".$_POST['process'];


if (!file_exists ( "../.env2" )){
    foreach ($env as $item){
        file_put_contents('../.env', $item.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}

echo "no Error";
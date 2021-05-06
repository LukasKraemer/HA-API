<?php
namespace Src;

use DateTime;
use DateTimeImmutable;
use PDO;
use Src\System\DatabaseConnector;

class Auth{

    private $token;
    private PDO $db;
    private bool $isToken = false;
    private array $logincredit= array(['username'=> null, 'pwd' =>null, 'permission'=> -1]);
    private $secret;

    public function __construct()
    {
        if(isset($_POST['username'], $_POST['password'])){
            $data= $_POST;
        }else{
        $data = json_decode(file_get_contents("php://input"), TRUE);
        }

        if (isset($data['username'], $data['password'])){
            //post
            $this->logincredit['username']= $data['username'];
            $this->logincredit['pwd']= $data['password'];
        }
        else if(isset($_SERVER["HTTP_AUTHORIZATION"])){
            if(str_starts_with($_SERVER["HTTP_AUTHORIZATION"], 'Bearer') || str_starts_with($_SERVER["HTTP_AUTHORIZATION"], '$')){
                //Barear Token
                $this->token= explode(" ", $_SERVER["HTTP_AUTHORIZATION"], 2)[1];
                $this->isToken=true;
            }

        }else if (isset($_SERVER['PHP_AUTH_PW'], $_SERVER['PHP_AUTH_USER'])){
            //Basic Auth
            $this->logincredit['username']= $_SERVER['PHP_AUTH_USER'];
            $this->logincredit['pwd']= $_SERVER['PHP_AUTH_PW'];

        }else{
            exit("Login Error");
        }
        $this->secret=$_ENV['JWT_SECRET'];

        $this->db = DatabaseConnector::$dbConnection;
    }

    public function getUserData(): array
    {
        $output = Array();
        $output['username']= $this->logincredit['username'];
        $output['date']= New DateTime();
        $output['permission']= $this->logincredit['permission'];
        return $output;
    }
    public function login():int
    //return Permission as Int
    {
        if($this->isToken == 1 || $this->isToken== true){
            $this->checkJWT($this->token);
        }
        //$this->logger();
        return $this->checkpermisson();
    }

    private function checkJWT($token):bool{

        // split the token
        $tokenParts = explode('.', $token);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signatureProvided = $tokenParts[2];

        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);
        $base64UrlSignature = $this->base64UrlEncode($signature);

        $signatureValid = ($base64UrlSignature === $signatureProvided);
        $data = json_decode($payload, true);

        $tokenExpired= ( $data['exp'] <= (new DateTimeImmutable())->getTimestamp());



        if(!$tokenExpired and $signatureValid){
            $this->logincredit['username']=$data['name'];
            if($this->checkpermisson() != -1){
                return true;
            }
        }else{
            if ($tokenExpired) {
                return $this->genToken();
            }
            if (!$signatureValid) {
                return false;
            }else{
                return false;
            }
        }
    }

    private function base64UrlEncode($text){
        return str_replace(
            ['+', '/', '='],
            ['-', '_', ''],
            base64_encode($text)
        );
    }

    public function genToken(): string
    {
        // Create the token header
        $header = json_encode([ 'typ' => 'JWT','alg' => 'HS256']);

        $counter = 1;//intval(file_get_contents('jwdinkrement.txt'));
        // Create the token payload
        $payload = json_encode([
            'user_id' => $counter,
            'name' => $this->logincredit['username'],
            'exp' => ($now = (new DateTimeImmutable())->modify('+6 month')->getTimestamp())
        ]);
        //file_put_contents('jwdinkrement.txt', $counter+1);
        $base64UrlHeader = $this->base64UrlEncode($header);
        $base64UrlPayload = $this->base64UrlEncode($payload);
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $this->secret, true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = $this->base64UrlEncode($signature);

        return $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;
    }

    private function logger($zusatz = "")
    {
        $table= $_ENV['table_api_logger'];
        $sql = "INSERT INTO $table (token, datum, ip, userAgend, functionsaufruf, parameter ) VALUES (?,?,?,?,?,?)";
        $this->db->prepare($sql)->execute([hash($_ENV['hashalgo'], (string)$this->logincredit['login']), date("d.m.Y H:i",time()), $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT'], $_GET['_url'], $zusatz]);
    }

    private function checkpermisson()
    {

        $data=$this->logincredit;
        $s=$_ENV['DB_SCHEMA'];
        $t=$_ENV['table_user'];
        $table= "$s.$t";

        if($this->isToken){

            $statement = $this->db->prepare("SELECT * FROM $table WHERE name like :user ;");
            $statement->execute(["user" => $data['username']]);
        }else{

            $statement = $this->db->prepare("SELECT * FROM $table WHERE name like :user and passwd = :pwd ; ");
            $statement->execute(['user' => $data['username'], 'pwd'=> hash($_ENV['hashalgo'], $data['pwd'])]);
        }
        if($statement->rowCount() ==1){
            $tokenReturn = $statement->fetch();
            //Token Check

            if ($tokenReturn !== false && $tokenReturn['permission']>= 1 && $tokenReturn['state_id'] == 1) {
                $this->logincredit['permission']= $tokenReturn['permission'];
                return $tokenReturn['permission'];
            } else {
                return 0;
            }
        }else{
            return -1;
        }
    }
}


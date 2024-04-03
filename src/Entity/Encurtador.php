<?php
namespace APP\Entity\Encurtador;
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Database.php';
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\APP\Common\Environment.php';
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Domains.php';
require_once 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\PutLogs.php';
//require 'C:\xampp\htdocs\API DATABASE\vendor\autoload.php';
use Database\Connection\database as DB;
use Exception;
use src\Include\Domains;

class Encurtador{
    //Atributos
    public $long_link;
    public $short_link;
    public $permanencia;
    public $data= [
        'ERROR'=> []
    ];


    public function __construct($long_link=null,$permanencia=null){

        if(filter_var($long_link, FILTER_VALIDATE_URL)){
            

            $domain = parse_url($this->long_link, PHP_URL_HOST);
            $list_domains = new Domains;

            if($list_domains->getDomainsByName($domain) == true){
                $this->long_link   = $long_link;
                $this->permanencia = $permanencia;
            }

            array_push($this->data['ERROR'], 'ERROR NON LISTED DOMAIN');
            $message = implode(',',$this->data['ERROR']);
            putLog("Erro em Entity Encurtador (construct) ".$message,'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_entity.txt');


        }else{
            
            array_push($this->data['ERROR'],'NOT VALIDATE URL');
            $message = implode(',',$this->data['ERROR']);
            putLog("Erro em Entity Encurtador (construct) ".$message,'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_entity.txt');

        }
        
        

    }

    public function encurtar(){
    try{
        $db_conn = new DB;
        $randomString = md5(uniqid());
        $numericOnly = preg_replace('/[0-9]/','',$randomString);
        $threeDigits = substr($numericOnly,0,5);
        $this->short_link = 'SB'.$threeDigits;
        //Verificação de duplicidade
        $consulta = $db_conn->dbConn('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt')
                    ->query('SELECT long_link FROM dbo.ENCURTADO');
        
        return $consulta;
        


    }catch(Exception $erro){
        $mensagem_erro = "Erro na entidade Encurtar (encurtar): ". $erro->getMessage();
        $path_log = 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_entity.txt';
        putLog($mensagem_erro,$path_log);        
    }
        
    }
    

}


/*$database_connection = new DB();
$consulta= $database_connection
            ->dbConn('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt')
                ->query("SELECT * FROM ENCURTADOS");


foreach ($consulta as $linha) {
    print_r($linha);
}*/

$encurtador = new Encurtador('https://www.youtube.com/watch?v=z5VC9Wnd8Wo&list=PLXik_5Br-zO8vLD6X9uB-EH6BpgZL8XBH&index=3');
$result = $encurtador->encurtar();
foreach($result as $r){
    echo $r[0];
}

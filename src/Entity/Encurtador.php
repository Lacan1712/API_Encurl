<?php
namespace APP\Entity\Encurtador;
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Database.php';
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\APP\Common\Environment.php';

//require 'C:\xampp\htdocs\API DATABASE\vendor\autoload.php';
use Database\Connection\database as DB;
use Exception;

class Encurtador{
    //Atributos
    public $long_link;
    public $short_link;
    public $permanencia;


    public function __construct($long_link=null,$permanencia=null){
        $this->long_link   = $long_link;
        $this->permanencia = $permanencia;

    }

    public function encurtar(){
    try{
        header("Content-Type: application-json");
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
        date_default_timezone_set('America/Boa_Vista');
        $mensagem_erro = "Erro na entidade Encurtar: ". $erro->getMessage();
        $path_log = 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_Entity';
        error_log(date("Y-m-d H:i:s")." ".$mensagem_erro.PHP_EOL, 3,$path_log);
                
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

$encurtador = new Encurtador();
$result = $encurtador->encurtar();
foreach($result as $r){
    echo $r[0];
}

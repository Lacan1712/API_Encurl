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
use PDO;


class Encurtador{
    //Atributos
    public $long_link;
    public $short_link;
    public $permanencia;
    public $data= [
        'ERROR'=> [],
        'ALERT'=>[],
        'RESPONSE'=> []
    ];


    public function __construct($long_link=null,$permanencia=null){

        if(filter_var($long_link, FILTER_VALIDATE_URL)){
            

            $domain = parse_url($long_link, PHP_URL_HOST);
            $list_domains = new Domains;

            if($list_domains->getDomainsByName($domain) == true){
                $this->long_link   = $long_link;
                $this->permanencia = $permanencia;
            }

            if($list_domains->getDomainsByName($domain) == false){
                array_push($this->data['ERROR'], 'ERROR NON LISTED DOMAIN');
                $message = implode(',',$this->data['ERROR']);
                putLog("Erro em Entity Encurtador (construct) ".$message,'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_entity.txt');
            }  

                
            

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
        $this->short_link = strval($threeDigits);
        //Verificação de duplicidade
        $stmt = $db_conn->dbConn('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt')
                        ->prepare("SELECT short_link,long_link FROM dbo.ENCURTADO WHERE long_link = ?");

        $stmt->bindParam(1,$this->long_link);
        $stmt->execute();
        $verify_long_link = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($verify_long_link){
            array_push($this->data['ALERT'], ['LINK_ALREDY_EXIST' => $verify_long_link['short_link']]);
        }else{

            $stmt = $db_conn->dbConn('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt')
                            ->prepare("INSERT INTO dbo.ENCURTADO (short_link, long_link, permanencia) VALUES (:short_link, :long_link, :permanencia)");

            //Vincular os valores da variável
            $stmt->bindParam(':short_link', $this->short_link);
            $stmt->bindParam(':long_link', $this->long_link);
            $stmt->bindParam(':permanencia', $this->permanencia);
            
            $stmt->execute();

            array_push($this->data['RESPONSE'],[
                'SHORT_LINK' => $this->short_link,
                'LONG_LINK' => $this->long_link,
                'PERMANENCIA'=>$this->permanencia
            ]);

        }       

    }catch(Exception $erro){
        $mensagem_erro = "Erro na entidade Encurtar (encurtar): ". $erro->getMessage();
        $path_log = 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_entity.txt';
        putLog($mensagem_erro,$path_log);        
    }finally{
        $db_conn = null;
    }
        
    }
    

}



$encurtador = new Encurtador('https://sebraepr-my.sharepoint.com/:b:/r/personal/dayana_palhano_rr_sebrae_com_br1/Documents/CARTILHA%20LGPD%20VF.pdf?csf=1&web=1&e=kbiwPa',0);
$result = $encurtador->encurtar();

if($encurtador->data){
    echo "<pre>";
    print_r($encurtador->data);
}

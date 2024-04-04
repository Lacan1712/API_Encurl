<?php
namespace APP\Entity\Desencurtador;
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Database.php';
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\APP\Common\Environment.php';
require_once 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\PutLogs.php';

//require 'C:\xampp\htdocs\API DATABASE\vendor\autoload.php';
use Database\Connection\database as DB;
use Exception;
use PDO;

class Desencurtador{
   
    public $short_link;
    public $desativado;

    public function desencurtar($short_link,$desativado){
        
        $this->short_link = $short_link;
        $this->desativado = $desativado;
        $db_conn = new DB;
        if($this->desativado == 1){
            try{

                $stmt = $db_conn->dbConn('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt')
                        ->prepare("DELETE FROM dbo.ENCURTADO WHERE short_link = ?");
                $stmt->bindParam(1,$this->short_link);
                $stmt->execute();


            }catch(Exception $e){
                return false;
                putLog("Erro em Entity Desencurtador (desencurtar) ".$e,'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_entity.txt');
            }
        }


        if($this->desativado == 0){
        
            $stmt = $db_conn->dbConn('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt')
                            ->prepare("SELECT long_link FROM dbo.ENCURTADO WHERE short_link = ?");
            $stmt->bindParam(1,$this->short_link);
            $stmt->execute();

            $long_link = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $long_link;
        }
        
        
    }
    

}


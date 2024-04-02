<?php
namespace APP\Entity\Desencurtador;
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Database.php';
require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\APP\Common\Environment.php';

//require 'C:\xampp\htdocs\API DATABASE\vendor\autoload.php';
use Database\Connection\database as DB;
class Desencurtador{
    
    

}


$database_connection = new DB('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt');

$consulta= $database_connection
            ->dbConn('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt')
                ->query("SELECT * FROM ENCURTADOS");


foreach ($consulta as $linha) {
    print_r($linha);
}

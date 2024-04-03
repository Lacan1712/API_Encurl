<?php
namespace Database\Connection;
require_once 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\PutLogs.php';

use \PDO;
use \PDOException;
use App\Common\Environment;


class database
{

    public function dbConn($pathToLog)
    {
        try{
            //Carregando variáveis de ambiente
            Environment::load('C:\xampp\htdocs\API ENCURTADOR\API_Encurl');
            $config = [
                'host' => getenv('DB_HOST'),
                'port' => getenv('DB_PORT'),
                'name' => getenv('DB_DATABASE'),
                'user' => getenv('DB_USERNAME'),
                'password' => getenv('DB_PASSWORD'),
                'connection' => getenv('DB_CONNECTION'),
                'options' => [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => true
                ]
            ];

            $dsn = "sqlsrv:Server={$config['host']};Database={$config['name']};Authentication=ActiveDirectoryIntegrated;TrustServerCertificate=true";
          
            
            $connection = new PDO(
                $dsn,
                $config['user'],
                $config['password'],
                $config['options']
            );
            
            
            return $connection;

        }catch(PDOException $erro){
                $mensagem_erro = "Erro ao conectar banco de dados: ". $erro->getMessage();
                $path_log = $pathToLog;
                putLog($mensagem_erro, $path_log);
        }

    }


}
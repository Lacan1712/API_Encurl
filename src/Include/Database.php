<?php
namespace Database\Connection;
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
                date_default_timezone_set('America/Boa_Vista');
                $mensagem_erro = "Erro ao conectar banco de dados: ". $erro->getMessage();
                $path_log = $pathToLog;
                error_log(date("Y-m-d H:i:s")." ".$mensagem_erro.PHP_EOL, 3,$path_log);
        }

    }


}
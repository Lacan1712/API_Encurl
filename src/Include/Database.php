<?php
namespace Database\Connection;
use \PDO;
use \PDOException;
use App\Common\Evironment;
//Carregando variáveis de ambiente

class database
{
    //Atributos
    public function createDatabaseConnection()
    {
        try{
            Evironment::load('C:\xampp\htdocs\API ENCURTADOR\API_Encurl');
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
            /*$username = "dev.rr";
            $password = "Asdf@123";*/
            
            $connection = new PDO(
                $dsn,
                $config['user'],
                $config['password'],
                $config['options']
            );
            
            
            return $connection;

        }catch(PDOException $erro){
                $mensagem_erro = "Erro ao conectar banco de dados: ". $erro->getMessage();
                $path_log = 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_database.txt';
                error_log(date("Y-m-d H:i:s")." ".$mensagem_erro.PHP_EOL, 3,$path_log);
        }

    }


}
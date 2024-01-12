<?php
namespace Database\Connection\Include;
use \PDO;
use \PDOException;

class database
{
    //Atributos
    public function createDatabaseConnection()
    {
        try{
            
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

            $dsn = "pgsql:host=127.0.0.1;port=5432;dbname=API;user=postgres;password=La0945687!";
            
            $connection = new PDO(
                $dsn,
                null,
                null,
                $config['options']
            );
            
            
            return $connection;

        }catch(PDOException $erro){
                $mensagem_erro = "Erro ao conectar banco de dados: ". $erro->getMessage();
                $path_log = "C:/xampp/htdocs/API DATABASE/src/include/Log_database.txt";
                error_log(date("Y-m-d H:i:s")." ".$mensagem_erro.PHP_EOL, 3,$path_log);
        }

    }


}
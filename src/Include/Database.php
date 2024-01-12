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
            Evironment::load("C:/xampp/htdocs/API DATABASE");
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

            $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['name']};user={$config['user']};password={$config['password']}";
            
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
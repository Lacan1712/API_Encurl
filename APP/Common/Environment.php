<?php
namespace App\Common;

class Environment{
    /**
     * @param string $dir caminho absoluto da pasta onde se encontra o arquivo .env
     */
    public static function load($dir){
        if(!file_exists($dir.'/.env')){
            return false;
        }

        //DEFINE VARIÁVEIS DE AMBIENTE

        $lines = file($dir.'\.env');
        
        foreach($lines as $line){
            putenv(trim($line));
        }


    }
}
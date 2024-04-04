<?php
namespace src\Include;
require_once 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\PutLogs.php';
require_once 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\PutLogs.php';

class Domains{

    private $list_domains_read;

    public function __construct(){

        $this->list_domains_read = fopen('C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\domains.csv','r');
        if ($this->list_domains_read === FALSE) {
            putLog('Erro em Domains (construct)','C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Log_domains.txt');
        }
    }

    public function getDomainsByName($domain):bool {
        // Reinicie o ponteiro do arquivo para o início
        rewind($this->list_domains_read);
    
        while (($data = fgetcsv($this->list_domains_read)) !== FALSE) {
            if (in_array($domain, $data)) {
                return true;
            }
        }
    
        // Se chegou até aqui, significa que o domínio não foi encontrado
        return false;
    }

}


?>
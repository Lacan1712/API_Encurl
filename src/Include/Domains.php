<?php
namespace src\Include;
require_once 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\PutLogs.php';

class Domains{

    private $list_domains = ['sebraepr-my.sharepoint.com'];



    public function setDomains($domain){
        array_push($this->list_domains, $domain);
    }

    public function getDomains(){
        return $this->list_domains;
    }

    public function getDomainsByName($domain):bool{

        if(in_array($domain, $this->list_domains)){
            return true;
        }
            return false;
    
    }

}


?>
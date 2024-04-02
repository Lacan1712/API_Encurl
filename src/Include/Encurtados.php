<?php

require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\src\Include\Database.php';

require 'C:\xampp\htdocs\API ENCURTADOR\API_Encurl\APP\Common\Environment.php';

//require 'C:\xampp\htdocs\API DATABASE\vendor\autoload.php';
use Database\Connection\database as DB;


$database_connection = new DB;

$shortlink = $database_connection->createDatabaseConnection();

$consulta = $shortlink->query("SELECT * FROM ENCURTADOS");

foreach ($consulta as $linha) {
    print_r($linha);
}

<?php

require 'C:\xampp\htdocs\API DATABASE\src\include\Database.php';
use Database\Connection\Include\database as DB;

$database_connection = new DB;

$shortlink = $database_connection->createDatabaseConnection();

$consulta = $shortlink->query("SELECT * FROM api_link");

foreach ($consulta as $linha) {
    print_r($linha);
}


<?php



function putLog($message, $path_log){
    date_default_timezone_set('America/Boa_Vista');
    file_put_contents($path_log, date("Y-m-d H:i:s")." ".$message.PHP_EOL, FILE_APPEND);

}
?>
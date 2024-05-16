<?php

session_start();
date_default_timezone_set('America/Santiago');

$host = "localhost";
    $user = "root";
    $clave = "";
    $bd = "card";

// Con un array de opciones
try {
    $dsn = "mysql:host=localhost;dbname=$bd";
    $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );
    $DB = new PDO($dsn, $user, $clave);
   } catch (PDOException $e){
    echo $e->getMessage();
   }
   // Con un el método PDO::setAttribute
   try {
    $dsn = "mysql:host=localhost;dbname=$bd";
    $DB = new PDO($dsn, $user, $clave);
    $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   } catch (PDOException $e){
    echo $e->getMessage();
}

define('CLIENT_ID', 'AaZLiLPbSW2QaxJxtZ6pJrS4iYzHucSguFks9vtGFtnFRYMgWZmLyMaNw3QdbrqojWHz9YsrL0LfUAvL');
define('LOCALE', 'es_ES');
define( 'MONEDA','USD');
define('KEY_TOKEN', "APR.wqc-334*");
?>
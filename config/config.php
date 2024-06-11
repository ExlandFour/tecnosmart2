<?php

session_start();
$num_cart = 0;
if (isset($_SESSION['carrito']['productos'])) {
    $num_cart = count($_SESSION['carrito']['productos']);
}
date_default_timezone_set('America/Santiago');

$host = "localhost";
    $user = "root";
    $clave = "";
    $bd = "tecnosmart";

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

define('CLIENT_ID', 'AfexrJxw5h5RVjGWG_xxnsT0JrMljttr-V_GYkNybamoRcDQfLYycAj8dr5KFJO2Z1mG2A65cwP-zvF6');
define('LOCALE', 'es_ES');
define( 'MONEDA','USD');
define('KEY_TOKEN', "APR.wqc-334*");
?>
<?php
require 'config/config.php';
require 'config/conexion.php';

$db = new Database();
$conexion = $db->conectar();

$json = file_get_contents('php://input');
$datos = json_decode($json,true);

print_r($datos);
if(is_array($datos)){
    $id_transaccion = $datos ['detalles']['id'];
    $total= $datos ['detalles']['purchase_units'][0]['amount']['value']; 
    $status = $datos ['detalles']['status'];
    $fecha = $datos ['detalles']['update_time'];
    $fecha_nueva = date('Y-m-d H:i:s', strtotime($fecha));
    $email = $datos ['detalles']['payer']['email_address'];
    $id_cliente = $datos['detalles']['payer']['payer_id'];

    $sql = $conexion->prepare("INSERT INTO compra (id_transaccion, fecha, status, email, id_cliente, total) VALUES (? ,?,?,?,?,?)");
    $sql ->execute([$id_transaccion, $fecha_nueva, $status, $email, $id_cliente, $total ]);
    $id = $conexion->lastInsertId();
    
    if( $id > 0){
        $productos = isset($_SESSION['carrito ']['productos']) ? $_SESSION['carrito']['productos']: null;
        
        if ($productos != null) {
            foreach ($productos as $clave => $cantidad) {
            
                $sql = $conexion->prepare("SELECT id, nombre, precio_normal, precio_rebajado, $cantidad AS cantidad FROM productos WHERE id=? AND activo=1");
                $sql->execute([$clave]);
                $row_prod = $sql->fetch (PDO:: FETCH_ASSOC);

                $sql_insert= $conexion->prepare("INSERT INTO detalle_compra (id_compra, id_producto, nombre, precio, cantidad) VALUES (?,?,?,?,?)");
                $sql_insert->execute([$id, $clave, $row_prod['nombre']]);
            }
        }
    }
    
}
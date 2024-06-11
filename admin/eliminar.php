<?php
require_once "../config/conexion.php";

// Crear una instancia de la clase Database
$db = new Database();
// Llamar al método conectar para obtener la conexión
$conexion = $db->conectar();

if (isset($_GET)) {
    if (!empty($_GET['accion']) && !empty($_GET['id'])) {
        $id = $_GET['id'];
        if ($_GET['accion'] == 'pro') {
            $query = $conexion->prepare("DELETE FROM productos WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            if ($query) {
                header('Location: productos.php');
            }
        }
        if ($_GET['accion'] == 'cli') {
            $query = $conexion->prepare("DELETE FROM categorias WHERE id = :id");
            $query->bindParam(':id', $id);
            $query->execute();
            if ($query) {
                header('Location: categorias.php');
            }
        }
    }
}
?>

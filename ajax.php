<?php
require_once "config/conexion.php";

// Creamos una instancia de la clase Database para obtener la conexión
$database = new Database();
$conexion = $database->conectar();

if (isset($_POST)) {
    if ($_POST['action'] == 'buscar') {
        $array['datos'] = array();
        $total = 0;
        for ($i=0; $i < count($_POST['data']); $i++) { 
            $id = $_POST['data'][$i]['id'];
            // Preparamos la consulta utilizando parámetros para evitar inyección SQL
            $query = $conexion->prepare("SELECT * FROM productos WHERE id = :id");
            // Asignamos el valor al parámetro :id
            $query->bindParam(':id', $id, PDO::PARAM_INT);
            // Ejecutamos la consulta
            $query->execute();
            // Obtenemos los resultados
            $result = $query->fetch(PDO::FETCH_ASSOC);
            $data['id'] = $result['id'];
            $data['precio'] = $result['precio_rebajado'];
            $data['nombre'] = $result['nombre'];
            $total = $total + $result['precio_rebajado'];
            array_push($array['datos'], $data);
        }
        $array['total'] = $total;
        echo json_encode($array);
        die();
    }
}
?>

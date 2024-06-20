<?php
require_once "../config/conexion.php";

$db = new Database();
// Llamar al método conectar para obtener la conexión
$conexion = $db->conectar();

$accion = isset($_POST['accion']) ? intval($_POST['accion']) : 0;

if ($accion == 1) {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $p_normal = $_POST['p_normal'];
    $p_rebajado = $_POST['p_rebajado'];
    $cantidad = $_POST['cantidad'];
    $modelo_3d = $_POST['modelo_3d'];
    $id_categoria = $_POST['categoria'];
    $id = intval($_POST['id']);

    // Lógica subida de archivos
    $imagen = '';
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $dir_subida = './fotos/';
        $fichero = pathinfo($_FILES['foto']['name']);
        $ext = strtolower($fichero['extension']);
        $nombrefoto = uniqid() . '.' . $ext;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $dir_subida . $nombrefoto)) {
            $imagen = $nombrefoto;
        }
    }

    if ($id > 0) {
        if ($imagen) {
            $sql = "UPDATE productos SET nombre=?, descripcion=?, precio_normal=?, precio_rebajado=?, cantidad=?, imagen=?, modelo_3d=? ,id_categoria=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute(array($nombre, $descripcion, $p_normal, $p_rebajado, $cantidad, $imagen, $id_categoria, $id));
        } else {
            $sql = "UPDATE productos SET nombre=?, descripcion=?, precio_normal=?, precio_rebajado=?, cantidad=?, modelo_3d=? ,id_categoria=? WHERE id=?";
            $stmt = $conexion->prepare($sql);
            $stmt->execute(array($nombre, $descripcion, $p_normal, $p_rebajado, $cantidad, $id_categoria, $id));
        }
    } else {
        $sql = "INSERT INTO productos (nombre, descripcion, precio_normal, precio_rebajado, cantidad, imagen, modelo_3d ,id_categoria) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute(array($nombre, $descripcion, $p_normal, $p_rebajado, $cantidad, $imagen, $id_categoria));
    }

    header('Location: ./');
    exit;

} elseif ($accion == 0) {
    if (!isset($_POST['id'])) {
        echo json_encode(['error' => 'ID no proporcionado']);
        exit();
    }

    $id = intval($_POST['id']);

    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id=?");
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute(array($id));
    $row = $stmt->fetch();

    echo json_encode($row);
    exit;
}

///--------------------------------------------------------------------------------------



?>

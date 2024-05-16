<?php
include('../config/config.php');

$accion=isset($_POST['accion'])?intval($_POST['accion']):0;

if($accion==1) {

$nombre=$_POST['nombre'];
$descripcion=$_POST['descripcion'];
$p_normal=$_POST['p_normal'];
$p_rebajado=$_POST['p_rebajado'];
$cantidad=$_POST['cantidad'];

$id_categoria=$_POST['categoria'];
$id=intval($_POST['id']);

//print_r($_POST); exit();

//TODO: Lógica subida de archivos
if(isset($_FILES['foto'])){
$dir_subida = './fotos/';
$fichero = pathinfo($_FILES['foto']['name']);
$ext=$fichero['extension'];
$ext=strtolower($ext);
$nombrefoto=uniqid() . '.' . $ext;


if (move_uploaded_file($_FILES['foto']['tmp_name'], $dir_subida.$nombrefoto)){

$imagen=$nombrefoto;
//FIN TODO: Lógica subida de archivos

}
} else {
    $imagen='';
}
if($id>0)
$sql="UPDATE productos SET nombre=?, descripcion=?, precio_normal=?, precio_rebajado=?, cantidad=?, imagen=?, id_categoria=? WHERE id=$id";
else
$sql="INSERT INTO productos (nombre,descripcion,precio_normal,precio_rebajado,cantidad, imagen, id_categoria) VALUES (?,?,?,?,?,?,?)";

$stmt = $DB->prepare($sql);

// Ejecutamos
$stmt->execute(array($nombre, $descripcion, $p_normal, $p_rebajado, $cantidad, $imagen, $id_categoria));

header('location: ./');


} 
if($accion==0) {

if(!isset($_POST['id'])) exit();

$id=intval($_POST['id']);


$stmt = $DB->prepare("SELECT * FROM productos WHERE id=?");

// Especificamos el fetch mode antes de llamar a fetch()
$stmt->setFetchMode(PDO::FETCH_ASSOC);
// Ejecutamos
$stmt->execute(array($id));
// Mostramos los resultados
$row = $stmt->fetch();

echo json_encode($row);

}
?>

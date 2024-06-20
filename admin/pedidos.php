<?php
require_once "../config/conexion.php";
include("includes/header.php");

$db = new Database();
// Conectar a la base de datos y obtener la conexión
$conexion = $db->conectar();

// Preparar y ejecutar la consulta
$query = $conexion->prepare("SELECT c.c_id, c.c_nombre, c.c_apellido, c.c_direccion, c.c_rut, p.nombre AS nombre, p.imagen AS imagen FROM cliente c INNER JOIN productos p ON p.id = c.id_producto ORDER BY c.c_id DESC");
$query->execute();
$results = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Pedidos</h1>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Dirección</th>
                        <th>Rut</th>
                        <th>Producto</th>
                        <th>Imagen</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $data) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($data['c_id']); ?></td>
                        <td><?php echo htmlspecialchars($data['c_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($data['c_apellido']); ?></td>
                        <td><?php echo htmlspecialchars($data['c_direccion']); ?></td>
                        <td><?php echo htmlspecialchars($data['c_rut']); ?></td>
                        <td><?php echo htmlspecialchars($data['nombre']); ?></td>
                        <td><img class="img-thumbnail" src="fotos/<?php echo htmlspecialchars($data['imagen']); ?>" width="50"></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include("includes/footer.php");
?>

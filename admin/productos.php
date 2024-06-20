<?php
require_once "../config/conexion.php";

// Crear una instancia de la clase Database
$db = new Database();
// Llamar al método conectar para obtener la conexión
$conexion = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $descripcion = $_POST['descripcion'];
    $especificaciones = $_POST['especificaciones'];
    $p_normal = $_POST['p_normal'];
    $p_rebajado = !empty($_POST['p_rebajado']) ? $_POST['p_rebajado'] : 0; // Verificación para precio rebajado
    $categoria = $_POST['categoria'];
    $modelo_3d = $_POST['modelo_3d'];
    $id = isset($_POST['id']) ? $_POST['id'] : null;

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $img = $_FILES['foto'];
        $tmpname = $img['tmp_name'];
        $fecha = date("YmdHis");
        $foto = $fecha . ".jpg";
        $destino = "../admin/fotos/" . $foto;
        move_uploaded_file($tmpname, $destino);
    } else {
        $foto = null;
    }

    if ($id) {
        // Actualizar producto existente
        $sql = "UPDATE productos SET nombre = :nombre, descripcion = :descripcion, especificaciones = :especificaciones, precio_normal = :p_normal, precio_rebajado = :p_rebajado, cantidad = :cantidad, id_categoria = :categoria, modelo_3d = :modelo_3d";
        if ($foto) {
            $sql .= ", imagen = :foto";
        }
        $sql .= " WHERE id = :id";
        
        $query = $conexion->prepare($sql);
        $query->bindParam(':id', $id);
    } else {
        // Insertar nuevo producto
        $sql = "INSERT INTO productos(nombre, descripcion, especificaciones, precio_normal, precio_rebajado, cantidad, imagen, modelo_3d, id_categoria) VALUES (:nombre, :descripcion, :especificaciones, :p_normal, :p_rebajado, :cantidad, :foto, :modelo_3d, :categoria)";
        $query = $conexion->prepare($sql);
    }

    // Asignar los valores a los parámetros de la consulta
    $query->bindParam(':nombre', $nombre);
    $query->bindParam(':descripcion', $descripcion);
    $query->bindParam(':especificaciones', $especificaciones);
    $query->bindParam(':p_normal', $p_normal);
    $query->bindParam(':p_rebajado', $p_rebajado);
    $query->bindParam(':cantidad', $cantidad);
    $query->bindParam(':modelo_3d', $modelo_3d);
    if ($foto) {
        $query->bindParam(':foto', $foto);
    }
    $query->bindParam(':categoria', $categoria);

    // Ejecutar la consulta
    $query->execute();

    header('Location: productos.php');
    exit;
}

include("includes/header.php");
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Productos</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirProducto"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Imagen</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Especificaciones</th>
                        <th>Precio Normal</th>
                        <th>Precio Rebajado</th>
                        <th>Cantidad</th>
                        <th>Modelo3D</th>
                        <th>Categoria</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Preparar la consulta SQL utilizando PDO
                    $query = $conexion->prepare("SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria ORDER BY p.id DESC");

                    // Ejecutar la consulta
                    $query->execute();

                    // Recorrer los resultados
                    while ($data = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                        <tr>
                            <td><img class="img-thumbnail" src="../admin/fotos/<?php echo $data['imagen']; ?>" width="50"></td>
                            <td><?php echo $data['nombre']; ?></td>
                            <td><?php echo $data['descripcion']; ?></td>
                            <td><?php echo $data['especificaciones']; ?></td>
                            <td><?php echo $data['precio_normal']; ?></td>
                            <td><?php echo $data['precio_rebajado']; ?></td>
                            <td><?php echo $data['cantidad']; ?></td>
                            <td><?php echo htmlspecialchars(substr($data['modelo_3d'], 0, 50)); ?></td>
                            <td><?php echo $data['categoria']; ?></td>
                            <td>
                                <form method="post" action="eliminar.php?accion=pro&id=<?php echo $data['id']; ?>" class="d-inline eliminar">
                                    <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>    
                                </form>
                                <button class="btn btn-info" type="button" onclick="editar(<?php echo $data['id']; ?>)">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>
                                
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal para crear o editar productos -->
<div id="productos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="nuevoProductoForm" method="post" enctype="multipart/form-data">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="especificaciones">Especificaciones</label>
                        <textarea class="form-control" id="especificaciones" name="especificaciones" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="p_normal">Precio Normal</label>
                        <input type="number" class="form-control" id="p_normal" name="p_normal" required>
                    </div>
                    <div class="form-group">
                        <label for="p_rebajado">Precio Rebajado</label>
                        <input type="number" class="form-control" id="p_rebajado" name="p_rebajado">
                    </div>

                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" class="form-control" id="cantidad" name="cantidad" required>
                    </div>
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <input type="file" class="form-control" id="foto" name="foto">
                    </div>
                    <div class="form-group">
                        <label for="modelo_3d">Modelo3D</label>
                        <textarea class="form-control" id="modelo_3d" name="modelo_3d" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="categoria">Categoría</label>
                        <select id="categoria" class="form-control" name="categoria" required>
                            <?php
                            $categorias = $conexion->query("SELECT * FROM categorias");
                            foreach ($categorias as $cat) { ?>
                                <option value="<?php echo $cat['id']; ?>"><?php echo $cat['categoria']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>


<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>


<script>
    document.getElementById('abrirProducto').addEventListener('click', function() {
        $('#productos').modal('show');
        // Limpiar el formulario y el campo de ID
        document.getElementById('nuevoProductoForm').reset();
        document.getElementById('id').value = '';
        $('#exampleModalLabel').text('Nuevo Producto');
    });

    function editar(id) {
        $('#productos').modal('show');
        console.log('este es el id ' + id);
    $.post('modificar.php', { id: id }, function(data) {
        if (data.error) {
            alert('Error: ' + data.error);
            return false;
        }

        $('#exampleModalLabel').text('Editar Producto');
        $('#id').val(data.id);
        $('#nombre').val(data.nombre);
        $('#descripcion').val(data.descripcion);
        $('#especifiaciones').val(data.especificaciones);
        $('#p_normal').val(data.precio_normal); // Suponiendo que 'p_normal' es el campo para el precio normal
        $('#p_rebajado').val(data.precio_rebajado);
        $('#cantidad').val(data.cantidad);
        $('#foto').val(data.foto);
        $('#modelo_3d').val(data.modelo_3d);
        $('#categorias').val(data.categoria);
    }, 'json')
    .fail(function(xhr, textStatus, errorThrown) {
        alert('Error en la solicitud: ' + errorThrown);
  
    });
    }

</script>




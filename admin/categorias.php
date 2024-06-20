<?php
require_once "../config/conexion.php";

// Crear una instancia de la clase Database y obtener la conexión
$db = new Database();
$conexion = $db->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['nombre'])) {
        $nombre = $_POST['nombre'];
        $stmt = $conexion->prepare("INSERT INTO categorias(categoria) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        if ($stmt->execute()) {
            header('Location: categorias.php');
            exit;
        } else {
            echo "Error: No se pudo insertar la categoría.";
        }
    }
}

include("includes/header.php");
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categorias</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" id="abrirCategoria"><i class="fas fa-plus fa-sm text-white-50"></i> Nuevo</a>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover table-bordered" style="width: 100%;">
                <thead class="thead-dark">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $conexion->prepare("SELECT * FROM categorias ORDER BY id DESC");
                    $stmt->execute();
                    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($result as $data) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($data['id']); ?></td>
                            <td><?php echo htmlspecialchars($data['categoria']); ?></td>
                            <td>
                                <button class="btn btn-info" type="button" onclick="editar(<?php echo $data['id']; ?>)">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </button>

                                <form method="get" action="eliminar.php" class="d-inline eliminar">
                                    <input type="hidden" name="accion" value="cli">
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">
                                    <button class="btn btn-danger" type="submit"><i class="fa-solid fa-trash"></i></button>    
                                </form>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div id="categorias" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="title">Nueva Categoria</h5>
                <button class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" autocomplete="off">
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input id="nombre" class="form-control" type="text" name="nombre" placeholder="Categoria" required>
                    </div>
                    <button class="btn btn-primary" type="submit">Registrar</button>
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
    document.getElementById('abrirCategoria').addEventListener('click', function() {
    $('#categorias').modal('show').on('shown.bs.modal', function () {
        document.getElementById('nuevaCategoriaForm').reset();
        document.getElementById('id').value = '';
        $('#exampleModalLabel').text('Nueva Categoría');
    });
    });


    function editar(id) {
    $.post('modificar.php', { id: id }, function(data) {
        if (data.error) {
            alert('Error: ' + data.error);
            return false;
        }

        $('#exampleModalLabel').text('Editar Producto');
        $('#id').val(data.id);
        $('#nombre').val(data.nombre);
        $('#categorias').modal('show');
    }, 'json')
    .fail(function(xhr, textStatus, errorThrown) {
        alert('Error en la solicitud: ' + errorThrown);
        
    });
    }

</script>

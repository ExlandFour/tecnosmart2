<?php 
require_once "config/conexion.php"; 
require_once "config/config.php"; 

// Crear una instancia de la clase Database
$db = new Database();
// Conectar a la base de datos y obtener la conexión
$conexion = $db->conectar();

$id = isset($_GET['id']) ? $_GET['id'] : '';
$token = isset($_GET['token']) ? $_GET['token'] : '';

if($id == '' || $token == ''){
    echo 'Error al procesar la petición';
    exit;
} else {
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    if($token == $token_tmp){
        $stmt = $conexion->prepare("SELECT id, nombre, descripcion, precio_rebajado, imagen, modelo_3d FROM productos WHERE id = ?");
        $stmt->execute([$id]); // Usamos execute con el array de parámetros en lugar de bind_param
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Usamos fetch en lugar de get_result

        if($result) {
            $nombre = $result['nombre'];
            $descripcion = $result['descripcion'];
            $precio_rebajado = $result['precio_rebajado'];
            $imagen = $result['imagen'];
            $modelo_3d = $result['modelo_3d'];
            // Aquí puedes hacer lo que necesites con los datos obtenidos
            // ...
        } else {
            echo 'Producto no encontrado';
        }
    } else {
        echo 'Error al procesar la petición';
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Carrito de Compras</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap CSS-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />

    <style>
        .custom-card {
            max-width: 1000px;
            margin: auto; /* Center the card horizontally */
            height: 400px; /* Control the height of the card */
        }
        .custom-card .row {
            height: 100%; /* Ensure the row takes the full height of the card */
        }
        .custom-card .card-body {
            color: black; /* Text color to black */
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .custom-card img {
            height: 100%; /* Ensure the image takes the full height of the card */
            width: 100%; /* Ensure the image takes the full width of its container */
            object-fit: cover; /* Ensures the image covers the area without distortion */
            border-top-left-radius: calc(.25rem - 1px); /* Adjust border radius for Bootstrap */
            border-bottom-left-radius: calc(.25rem - 1px); /* Adjust border radius for Bootstrap */
        }
        .navbar {
            border-bottom: 2px solid black; /* Add a black border only to the bottom of the navbar */
        }
    </style>

</head>
<body class="bg-dark">
    <a href="#" class="btn-flotante" id="btnCarrito">Carrito <span class="badge bg-success" id="carrito">0</span></a>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><img src="https://i.imgur.com/9tfLHB6.png" alt="Logo de TecnoSmart" style="max-height: 38px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-info" href="#" category="all">Todo</a>
                    </li>
                    <?php
                    // Crear una instancia de la clase Database
                    $db = new Database();
                    // Conectar a la base de datos y obtener la conexión
                    $conexion = $db->conectar();

                    $query = "SELECT * FROM categorias"; // Consulta SQL para obtener categorías
                    $stmt = $conexion->prepare($query);
                    $stmt->execute();
                    
                    while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                        <li class="nav-item">
                            <a class="nav-link" href="./" category="<?php echo htmlspecialchars($data['categoria']); ?>">
                                <?php echo htmlspecialchars($data['categoria']); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card custom-card text-dark bg-white mb-3">
            <div class="row no-gutters h-100">
                <div class="col-md-6">
                    <img src="admin/fotos/<?php echo htmlspecialchars($imagen); ?>" class="card-img" alt="<?php echo htmlspecialchars($nombre); ?>">
                </div>
                <div class="col-md-6">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($nombre); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($descripcion); ?></p>
                        <p class="card-text"><small>Precio Rebajado: <?php echo htmlspecialchars($precio_rebajado); ?></small></p>

                        <div class="text-center">

                        </div>

                        <div class="text-center">
                            <button class="btn btn-primary" type="button">comprar ahora</button>
                            <button class="btn btn-outline-primary" type="button" onclick="addProducto(<?php echo $id; ?>, '<?php echo $token_tmp; ?>')" >Agregar al carrito </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS and Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script>
        function addProducto(id, token){
            let url = './carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
        }
    </script>

</body>
</html>

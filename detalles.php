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
        $stmt = $conexion->prepare("SELECT id, nombre, descripcion, especificaciones, precio_normal, precio_rebajado, imagen, modelo_3d FROM productos WHERE id = ?");
        $stmt->execute([$id]); // Usamos execute con el array de parámetros en lugar de bind_param
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Usamos fetch en lugar de get_result

        if($result) {
            $nombre = $result['nombre'];
            $descripcion = $result['descripcion'];
            $especificaciones = $result['especificaciones'];
            $precio_normal = $result['precio_normal'];
            $precio_rebajado = $result['precio_rebajado'];
            $imagen = $result['imagen'];
            $modelo_3d = $result['modelo_3d'];


            $imagen_src = 'admin/fotos/' . $imagen;
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
    <title>Detalle del producto</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/icono.ico" />
    <!-- Bootstrap CSS-->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
    <link href="assets/css/app.css" rel="stylesheet"/>
    <script defer src="assets/js/app.js"></script>

    <style>
        .custom-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            width: 1020px;  /* Ancho fijo */
            height: 480px; /* Altura fija */
        }

        .custom-card:hover {
            transform: translateY(-5px);
        }

        .custom-card img {
            border-top-left-radius: 15px;
            border-bottom-left-radius: 15px;
            object-fit: cover;
            height: 100%;
        }

        .custom-card .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%; /* Asegura que el contenido se distribuya correctamente */
        }

        .custom-card .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .custom-card .card-text {
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .custom-card .card-text small {
            font-size: 1.1rem;
            color: #e74c3c;
        }

        .custom-card .btn {
            margin: 5px;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 50px;
            transition: background-color 0.3s, color 0.3s;
        }

        .custom-card .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }

        .custom-card .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }

        .custom-card .btn-outline-primary {
            border-color: #3498db;
            color: #3498db;
        }

        .custom-card .btn-outline-primary:hover {
            background-color: #3498db;
            color: #fff;
        }

        .custom-card .btn i {
            margin-right: 10px;
        }

        .precio-tachado {
            text-decoration: line-through;
            color: black;
        }

        .nav-tabs {
            margin-bottom: 1rem; /* Ajusta el margen inferior de los nav-tabs */
        }

        .tab-content > .tab-pane {
            margin-top: 1rem; /* Ajusta el margen superior de las pestañas */
        }

        ul {
            list-style-type: none; /* Elimina los puntos de la lista */
            padding: 0;
        }
        
        li {
            margin-bottom: 6px; /* Espaciado entre elementos de la lista */
            font-size: 0.8em; /* Tamaño de fuente más pequeño para todo el contenido */
            line-height: 1.4; /* Espaciado entre líneas */
        }
        
        li strong {
            font-weight: bold; /* Aplica negrita solo a los elementos <strong> dentro de <li> */
            font-size: 0.9em; /* Tamaño de fuente para los títulos */
            display: inline-block; /* Para que cada título esté en una línea separada */
            width: 160px; /* Ancho fijo para alinear los títulos */
        }
        
        li span {
            font-size: 0.8em; /* Tamaño de fuente más pequeño para los valores */
        }

    </style>

    <style>
        /* Estilos para la barra de navegación */
        .navbar-nav {
            margin-right: auto; /* Empuja los elementos a la izquierda */
        }
        .nav-item {
            margin-right: 10px; /* Espacio entre elementos de navegación */
        }
        .nav-link {
            color: white; /* Color del texto de los enlaces */
        }
        .nav-link:hover {
            color: lightgray; /* Cambia el color del texto al pasar el mouse */
        }
        .navbar {
            border-bottom: 2px solid black; /* Add a black border only to the bottom of the navbar */
        }
        .card-text:last-child::before {
            font-weight: bold;
        }
        p.card-text:contains('Precio Normal:') {
            font-weight: bold;
        }

        p.card-text:contains('Precio Rebajado:') {
            font-weight: bold;
        }
    </style>

</head>
<body class="bg-dark">

    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="./">
            <img src="https://i.imgur.com/9tfLHB6.png" alt="Logo de TecnoSmart" style="max-height: 70px;">
        </a>
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
            <div class="d-flex">
                <a href="#" class="btn btn-primary me-2" id="btnCarrito">Carrito <span class="badge bg-secondary" id="carrito">0</span></a>
            </div>
        </div>
    </div>
</nav>



    <div class="container mt-5">
    <div class="card custom-card text-dark bg-white p-5">
        <div class="row no-gutters">
            <!-- Primera columna (col-md-6) -->
            <div class="col-md-6">
                <div class="contenedor">
                    <ul class="ul">
                        <li class="li activo">Imagen Referencial</li>
                        <li class="li">Modelo 3d</li>
                    </ul>

                    <div class="subcontenedor">
                        <div class="bloque activo mb-2">
                            <?php if (!empty($imagen_src)): ?>
                                <img src="<?php echo $imagen_src; ?>" alt="Imagen desde base de datos">
                            <?php else: ?>
                                <p>No se encontró ninguna imagen</p>
                            <?php endif; ?>
                        </div>
                        <div class="bloque">
                            <?php if (!empty($modelo_3d)): ?>
                                <?php echo $modelo_3d; // Mostrar directamente el contenido del modelo_3d ?>
                            <?php else: ?>
                                <p>No se encontró un modelo 3D para mostrar.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div> 

            <!-- Segunda columna (col-md-6) -->
            <div class="col-md-6">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Detalles</button>
                            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Especificaciones</button>

                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <h4 class="card-title"><?php echo htmlspecialchars($nombre); ?></h4>
                            <p class="card-text"><?php echo htmlspecialchars($descripcion); ?></p>
                            <p class="card-text" style="font-weight: bold;">Precio Normal: <span class="precio-tachado"><?php echo htmlspecialchars($precio_normal); ?></span></p>
                            <p class="card-text" style="font-weight: bold;"><small>Precio Rebajado: <?php echo htmlspecialchars($precio_rebajado); ?></small></p>

                            <button class="btn btn-primary" type="button" onclick="window.location.href='carrito1.php'">Comprar ahora</button>
                            <button class="btn btn-outline-primary mt-auto agregar" data-id="<?php echo htmlspecialchars($id); ?>" href="#">Agregar</button>
                        </div>
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                            <p class="card-text"><?php echo html_entity_decode($especificaciones); ?></p>
                    
                        </div>
                     </div>
            </div>
        </div>
    </div>
</div> 

    <footer class="py-5 bg-secondary mt-5 ">
        <div class="container mb-">
            <p class="m-0 text-center text-white">Derechos Reservados Marcelo Quinchagual &copy; Pagina Creada desde el 10 de mayo</p>
        </div>
    </footer>

    <!-- JS and Bootstrap scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script defer src="assets/js/app.js"></script>


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
<script src="//code.tidio.co/zyujhh3zfwxwmfo8nr0cxfnzlodkxyce.js" async></script>

</body>
</html>

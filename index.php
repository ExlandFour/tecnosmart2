<?php require_once "config/conexion.php"; ?>
<?php require_once "config/config.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>TecnoSmart</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/icono.ico" />
    <!-- Bootstrap CSS-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Core theme CSS -->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
    <style>
        .navbar {
            border-bottom: 2px solid black; /* Add a black border only to the bottom of the navbar */
        }
    </style>
</head>
<body class="bg-dark">
    <!-- Connect to Database -->
    <?php
    $db = new Database();
    $conexion = $db->conectar();
    ?>


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
                    $query = $conexion->query("SELECT * FROM categorias");
                    $categorias = $query->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($categorias as $categoria) {
                        echo '<li class="nav-item"><a class="nav-link" href="#" category="' . $categoria['categoria'] . '">' . $categoria['categoria'] . '</a></li>';
                    }
                    ?>
                </ul>
   
                <a href="#" class="btn btn-primary" id="btnCarrito">Carrito <span class="badge bg-secondary" id="carrito">0</span></a>
   
            </div>
        </div>
    </nav>

    <!-- Header-->
    <header class="bg-dark py-5 text-white text-center" style="background-image: url('https://imgur.com/uFwMrH4.png'); background-size: cover; background-position: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="position-relative">
                <h1 class="display-4 fw-bolder">Bienvenidos a TecnoSmart</h1>
                <p class="lead fw-normal text-secondary-50 mb-0">Encuentra todos tus....</p>
            </div>
        </div>
    </header>

    <!-- Productos -->
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php
                $query = $conexion->query("SELECT p.*, c.id AS id_cat, c.categoria FROM productos p INNER JOIN categorias c ON c.id = p.id_categoria");
                $productos = $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ($productos as $producto) {
                    $id = $producto['id'];
                    $token_tmp = hash_hmac('sha1', $producto['id'], KEY_TOKEN);
                    echo '<div class="col mb-5 productos" category="' . $producto['categoria'] . '">
                            <div class="card h-100">
                                <div class="badge bg-danger text-white position-absolute" style="top: 0.5rem; right: 0.5rem">' . ($producto['precio_normal'] > $producto['precio_rebajado'] ? 'Oferta' : '') . '</div>
                                <img class="card-img-top" src="admin/fotos/' . $producto['imagen'] . '" alt="..." />
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <h5 class="fw-bolder">' . $producto['nombre'] . '</h5>
                                        <p>' . $producto['descripcion'] . '</p>
                                        <div class="d-flex justify-content-center small text-warning mb-2">';
                    for ($i = 0; $i < 5; $i++) {
                        echo '<div class="bi-star-fill"></div>';
                    }
                    echo '</div>
                                        <span class="text-muted text-decoration-line-through">' . $producto['precio_normal'] . '</span>
                                        ' . $producto['precio_rebajado'] . '
                                    </div>
                                </div>
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center">
                                        <a class="btn btn-outline-dark mt-auto agregar" data-id="' . $producto['id'] . '" href="#">Agregar</a>
                                        <a href="detalles.php?id=' . $producto['id'] . '&token=' . hash_hmac('sha1', $producto['id'], KEY_TOKEN) . '" class="btn btn-primary">Detalles</a>
                                    </div>
                                </div>
                            </div>
                        </div>';
                }
                ?>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-secondary">
        <div class="container">
            <p class="m-0 text-center text-white">Derechos Reservados Marcelo Quinchagual &copy; Pagina Creada desde el 10 de mayo</p>
        </div>
    </footer>

    <!-- Bootstrap core JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS -->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>

    <script>
        function addProducto(id, token){
            let url = 'clases/carrito.php'
            let formData = new FormData()
            formData.append('id', id)
            formData.append('token', token)

            fetch(url, {
                method: 'POST',
                body: formData,
                mode: 'cors'
            }).then(response => response.json())
            .then(data =>{
                if(data.ok){
                    let elemento = document.getElementById("num_cart")
                    elemento.innerHTML = data.numero
                }
            })
        }
    </script>

</body>
</html>

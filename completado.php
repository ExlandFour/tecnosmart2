<?php 
require_once "config/conexion.php";
require_once "config/config.php";
$db = new Database();
$conexion = $db->conectar();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="assets/css/styles.css" rel="stylesheet" />
    <link href="assets/css/estilos.css" rel="stylesheet" />
</head>
<body>
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
                    // Conexión a la base de datos y consulta de categorías
                    require_once "config/conexion.php";
                    $db = new Database();
                    $conexion = $db->conectar();
                    
                    $query = $conexion->query("SELECT * FROM categorias");
                    $categorias = $query->fetchAll(PDO::FETCH_ASSOC);
                    
                    // Iteración sobre las categorías para mostrar en el navbar
                    foreach ($categorias as $categoria) {
                        echo '<li class="nav-item"><a class="nav-link" href="#" category="' . $categoria['categoria'] . '">' . $categoria['categoria'] . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Aquí puedes continuar con el resto de tu contenido PHP/HTML -->

    <?php
    // procesar_pago.php

    // Procesamiento del pago y otras operaciones necesarias
    // Aquí es donde se procesa el pago con la pasarela de pagos y se recibe la confirmación de éxito

    // Por simplicidad, simulemos que el pago se procesó con éxito
    $payment_successful = true;

    if ($payment_successful) {
        // Establecer variable de sesión para indicar que se ha completado el pago
        session_start();
        $_SESSION['compra_exitosa'] = true;

        // Redirigir a la página de confirmación o a donde sea necesario
        header('Location: gracias.php');
        exit;
    } else {
        // Manejar el caso de pago fallido
        echo "El pago no se pudo procesar correctamente. Por favor, inténtalo de nuevo.";
        // Aquí puedes redirigir o mostrar algún mensaje de error según tu aplicación
    }
    ?>

    <!-- Bootstrap JS bundle (Popper included) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>

<?php
session_start(); // Iniciar la sesión si aún no está iniciada

// Verificar si la variable de sesión está establecida y es verdadera
if (isset($_SESSION['compra_exitosa']) && $_SESSION['compra_exitosa']) {
    require_once "config/conexion.php";
    $db = new Database();
    $conexion = $db->conectar();

    // Consulta de categorías
    $query = $conexion->query("SELECT * FROM categorias");
    $categorias = $query->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias por tu compra</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php"><img src="https://i.imgur.com/9tfLHB6.png" alt="Logo de TecnoSmart" style="max-height: 38px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-info" href="#" category="all">Todo</a>
                    </li>
                    <?php
                    // Iteración sobre las categorías para mostrar en el navbar
                    foreach ($categorias as $categoria) {
                        echo '<li class="nav-item"><a class="nav-link" href="#" category="' . $categoria['categoria'] . '">' . $categoria['categoria'] . '</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">¡Gracias por tu compra!</h2>
        <p class="text-center">Tu pedido ha sido procesado con éxito.</p>
    </div>

    <!-- Bootstrap JS y Popper.js (opcional, si se necesitan) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    // Limpiar la variable de sesión después de mostrar el mensaje
    unset($_SESSION['compra_exitosa']);
} else {
    // Si la variable de sesión no está establecida o no es verdadera, redirigir a otra página o realizar otra acción
    header('Location: index.php'); // Por ejemplo, redirigir a la página principal
    exit;
}
?>

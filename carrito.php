<?php 
require_once "config/conexion.php";
require_once "config/config.php";

// Inicializar las variables $id y $token
$id = $token = "";

// Verificar si se han enviado los datos del formulario
if (isset($_POST['id'], $_POST['token'])) {
    $id = $_POST['id'];
    $token = $_POST['token'];
}

// Verificar si la sesión 'carrito' está iniciada
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = array('productos' => array());
}

$datos = array();

// Verificar si las variables están definidas antes de usarlas
if (!empty($id) && !empty($token)) {
    // Calcula el token temporal
    $token_tmp = hash_hmac('sha1', $id, KEY_TOKEN);

    // Verifica si los tokens coinciden
    if ($token === $token_tmp) {
        if (isset($_SESSION['carrito']['productos'][$id])) {
            $_SESSION['carrito']['productos'][$id] += 1;
        } else {
            $_SESSION['carrito']['productos'][$id] = 1;
        }

        $datos['numero'] = count($_SESSION['carrito']['productos']);
        $datos['ok'] = true;
    } else {
        // Si los tokens no coinciden, establece 'ok' como false
        $datos['ok'] = false;
    }
} else {
    // Si los datos 'id' y 'token' no están seteados, establece 'ok' como false
    $datos['ok'] = false;
}

// Envía la respuesta JSON
echo json_encode($datos);
?>


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

    <script src="https://www.paypal.com/sdk/js?client-id=AfexrJxw5h5RVjGWG_xxnsT0JrMljttr-V_GYkNybamoRcDQfLYycAj8dr5KFJO2Z1mG2A65cwP-zvF6&currency=USD">
    </script>

</head>
<body>
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="./"><img src="https://i.imgur.com/9tfLHB6.png" alt="Logo de TecnoSmart" style="max-height: 40px;"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Header-->
    <header class="bg-dark py-5">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
                <h1 class="display-4 fw-bolder">Carrito</h1>
                <p class="lead fw-normal text-white-50 mb-0">Tus Productos Agregados.</p>
            </div>
        </div>
    </header>
    
    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Sub Total</th>
                                </tr>
                            </thead>
                            <tbody id="tblCarrito"></tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-5 ms-auto">
                    <h4>Total a Pagar: <span id="total_pagar">0.00</span></h4>
                    <div class="d-grid gap-2">
                        <button class="btn btn-warning" type="button" id="btnVaciar">Vaciar Carrito</button>
                        <div id="paypal-button-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website <?php echo date("Y"); ?></p>
        </div>
    </footer>

    
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/scripts.js"></script>
    <script>
        function mostrarCarrito() {
            if (localStorage.getItem("productos")) {
                let array = JSON.parse(localStorage.getItem('productos'));
                if (array.length > 0) {
                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        async: true,
                        data: {
                            action: 'buscar',
                            data: array
                        },
                        success: function(response) {
                            console.log(response);
                            const res = JSON.parse(response);
                            let html = '';
                            res.datos.forEach(element => {
                                html += `
                                    <tr>
                                        <td>${element.id}</td>
                                        <td>${element.nombre}</td>
                                        <td>${element.precio}</td>
                                        <td>1</td>
                                        <td>${element.precio}</td>
                                    </tr>
                                `;
                            });
                            $('#tblCarrito').html(html);
                            $('#total_pagar').text(res.total);
                        }   
                    });
                }
            }
        }
        
        // Llamada a la función mostrarCarrito al cargar la página
        $(document).ready(function() {
            mostrarCarrito();
        });
    </script>
    
    <body>
        <div id= "paypal-button-container"></div>
    <script>
            paypal.Buttons({
                style:{
                    color: 'blue',
                    shape: 'pill',
                    label: 'pay'
                },
                createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value:100
                        }
                    }]
                })
            },

            onApprove: function(data, actions){
                actions.order.capture().then(function (detalles){
                    window.location.href="completado.php"
                });


            },

            onCancel: function(data){
                alert("¡Pago Cancelado!")
                console.log(data);
            }
            }).render('#paypal-button-container');

    </script>


 

</body>

<h1>Conversor de USD a CLP</h1>
    <label for="usdInput">Ingresa la cantidad de USD:</label>
    <input type="number" id="usdInput">
    <button onclick="convertir()">Convertir</button>
    <p id="resultado"></p>

    <script>
        function convertir() {
            // Obtener el valor ingresado en el input
            //siiiiii
            var usd = parseFloat(document.getElementById('usdInput').value);

            // Tasa de cambio USD a CLP (ejemplo, puedes cambiar este valor por el actual)
            var tasaCambio = 850; // 1 USD = 850 CLP

            // Calcular el equivalente en CLP
            var clp = usd * tasaCambio;

            // Mostrar el resultado
            document.getElementById('resultado').innerText = usd + ' USD equivale a ' + clp.toFixed(2) + ' CLP';
        }
    </script>
</html>

<?php 
require_once "config/conexion.php";
require_once "config/config.php";
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
    
    <!-- Script para inicializar el botón de PayPal -->
    <script>
        function initPayPalButton() {
            paypal.Buttons().render('#paypal-button-container');
        }
    </script>
    <script src="https://www.paypal.com/sdk/js?client-id=AaZLiLPbSW2QaxJxtZ6pJrS4iYzHucSguFks9vtGFtnFRYMgWZmLyMaNw3QdbrqojWHz9YsrL0LfUAvL&currency=USD" onload="initPayPalButton()"></script>
</body>

<h1>Conversor de USD a CLP</h1>
    <label for="usdInput">Ingresa la cantidad de USD:</label>
    <input type="number" id="usdInput">
    <button onclick="convertir()">Convertir</button>
    <p id="resultado"></p>

    <script>
        function convertir() {
            // Obtener el valor ingresado en el input
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

<!doctype html>
<html>
    <head>
        <title>Inventario Productos</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link rel="stylesheet" href="../css/bootstrap.min.css">
        <script src="../js/jquery.min.js"></script>
        <script src="../js/popper.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    </head>
    <body>
        <?php include('../Utilitarios/Navegacion_Clientes.php'); ?>
        <div class="container">
            <h1>Inventario Productos</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>CODIGO</th>
                        <th>NOMBRE</th>
                        <th>CANTIDAD</th>
                        <th>VALORUNITARIO</th>
                    </tr>
                </thead>
                <tbody id="datos">
                </tbody>
            </table>
            <button type="button" id="btnRegresar" class="btn btn-success">Regresar</button>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var producto;
                MostrarProductos();
                $('#btnRegresar').click(function () {
                    window.location = '../index.php';
                });
                function MostrarProductos() {
                    $.ajax({
                        type: 'GET',
                        url: 'Procesar_Productos.php?accion=listar',
                        success: function (productos) {
                            let filas = '';
                            for (let producto of productos) {
                                filas += '<tr><td>' + producto.codigo + '</td><td>' + producto.nombre + '</td><td>' + producto.cantidad + '</td><td>' + producto.valorunitario + '</td>';
                            }
                            $('#datos').html(filas);
                        },
                        error: function () {
                            alert("Hay un error...");
                        }
                    });
                }
                //Funciones AJAX para enviar y recuperar datos del servidor
                //******************************************************* 
                function EnviarInformacion(accion) {
                    $.ajax({
                        type: 'POST',
                        url: 'Procesar_Productos.php?accion=' + accion,
                        data: producto,
                        success: function (msg) {
                            MostrarProductos();
                        },
                        error: function () {
                            alert("Hay un error ..");
                        }
                    });
                }
            });
        </script>
    </body>
</html>
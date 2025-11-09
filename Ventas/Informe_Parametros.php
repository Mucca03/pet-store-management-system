<!doctype html>
<html lang="es">

<head>
  <title>Información Parametros</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
    <!-- jQuery -->
        <script src="/proyAppsMascotas/js/jquery.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="/proyAppsMascotas/js/bootstrap.bundle.min.js"></script>
        <!-- Font Awesome JS -->
        <script src="/proyAppsMascotas/js/all.min.js"></script>
        <?php include('../Utilitarios/Navegacion_Admin.php'); ?>  
<div  class="container">
    <!-- Encabezado -->
    <!-- Tabla de Facturas Generadas -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];

        // Formatear las fechas en el formato esperado por MySQL
        $fechaInicioFormateada = date('Y-m-d', strtotime($fechaInicio));
        $fechaFinFormateada = date('Y-m-d', strtotime($fechaFin));

        require("../ConfiguracionBD/ConexionBD.php");
        $conexion = retornarConexion();
        $consulta = mysqli_query(
            $conexion,
            "SELECT 
                fact.nropedido AS numpedido,
                DATE_FORMAT(ped.fechaentrega, '%d/%m/%Y') AS fecha,
                empresa,
                ped.comentario,
                ROUND(SUM(deta.preciounitario * deta.cantidadvendida), 2) AS totalfactura
            FROM 
                pedidos AS fact 
            JOIN 
                clientes AS cli ON cli.nit = fact.nit
            JOIN 
                ventas AS deta ON deta.nropedido = fact.nropedido
            JOIN
                pedidos AS ped ON ped.nropedido = fact.nropedido
            WHERE 
                ped.fechaentrega BETWEEN '$fechaInicioFormateada' AND '$fechaFinFormateada'
            GROUP BY 
                deta.nropedido
            ORDER BY 
                numpedido DESC;"
        ) or die(mysqli_error($conexion));

        $filas = mysqli_fetch_all($consulta, MYSQLI_ASSOC);

        if (empty($filas)) {
            echo "<p>No se encontraron facturas para el rango de fechas seleccionado.</p>";
        } else {
            echo "<h3>Facturas generadas para el rango de fechas entre $fechaInicio y $fechaFin</h3>";
            echo "<table class='table table-striped'>";
            echo "<thead>
                    <tr>
                        <th>Factura</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Comentario</th>
                        <th class='text-right'>Total Factura</th>
                    </tr>
                </thead>
                <tbody>";
            foreach ($filas as $fila) {
                echo "<tr>
                        <td>{$fila['numpedido']}</td>
                        <td>{$fila['empresa']}</td>
                        <td>{$fila['fecha']}</td>
                        <td>{$fila['comentario']}</td>
                        <td class='text-right'>{$fila['totalfactura']}</td>
                    </tr>";
            }
            echo "</tbody></table>";
        }
    }
    ?>
    
    <!-- Formulario de Informes por Parámetros -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <h3>Informes por parámetros</h3>
        <div class="form-group">
            <label for="fechaInicio">Fecha de inicio:</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio">
        </div>
        <div class="form-group">
            <label for="fechaFin">Fecha de fin:</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin">
        </div>
        <button type="submit" class="btn btn-primary">Generar Informe</button>
    </form>
</div>

</body>

</html>
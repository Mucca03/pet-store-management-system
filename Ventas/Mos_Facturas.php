<!doctype html>
<html lang="es">

<head>
  <title>Index</title>
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
 <?php
    require("../ConfiguracionBD/ConexionBD.php");
    $conexion = retornarConexion();
    $consulta = mysqli_query(
      $conexion,
      "SELECT 
    fact.nropedido AS numpedido,
    DATE_FORMAT(fact.fechaentrega, '%d/%m/%Y') AS fecha,
    emp.nombre AS nombre_empleado,
    empresa,
    comentario,
    ROUND(SUM(deta.preciounitario * deta.cantidadvendida), 2) AS totalfactura
FROM 
    pedidos AS fact 
JOIN 
    clientes AS cli ON cli.nit = fact.nit
JOIN 
    ventas AS deta ON deta.nropedido = fact.nropedido
JOIN 
    empleado AS emp ON emp.id = fact.id_empleado
GROUP BY 
    fact.nropedido
ORDER BY 
    numpedido DESC;
"
    )
      or die(mysqli_error($con));

    $filas = mysqli_fetch_all($consulta, MYSQLI_ASSOC);

    ?>
    <h3 style="text-align: center">Facturas generadas</h3>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Factura</th>
          <th>Cliente</th>
          <th>Empleado</th>
          <th>Fecha</th>
          <th>Comentario</th>
          <th class="text-right">Total Factura</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <?php
        foreach ($filas as $fila) {
          ?>
          <tr>
            <td><?php echo $fila['numpedido'] ?></td>
            <td><?php echo $fila['empresa'] ?></td>
            <td><?php echo $fila['nombre_empleado'] ?></td>
            <td><?php echo $fila['fecha'] ?></td>
            <td><?php echo $fila['comentario'] ?></td>
            <td class="text-right"><?php echo '$' . number_format($fila['totalfactura'], 2, ',', '.'); ?></td>
            <td class="text-right">
              <a class="btn btn-primary btn-sm botonimprimir" role="button" href="#" data-codigo="<?php echo $fila['numpedido'] ?>">Imprimir</a>
              <a class="btn btn-primary btn-sm botonborrar" role="button" href="#" data-codigo="<?php echo $fila['numpedido'] ?>">Eliminar</a>
            </td>
          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
    <button type="button" id="btnNuevaFactura" class="btn btn-success">Generar venta</button>
  </div>

  <!-- ModalConfirmarBorrar -->
  <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
    <div class="modal-dialog" style="max-width: 600px" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h1>¿Realmente quiere borrar la factura?</h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-footer">
          <button type="button" id="btnConfirmarBorrado" class="btn btn-success">Confirmar</button>
          <button type="button" data-dismiss="modal" class="btn btn-success">Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener("DOMContentLoaded", function() {

      $('#btnNuevaFactura').click(function() {
        window.location = 'Ventas/Facturacion.php';
      });

      var codigofactura;

      $('.botonborrar').click(function() {
        codigofactura = $(this).get(0).dataset.codigo;
        $("#ModalConfirmarBorrar").modal();
      });

      $('#btnConfirmarBorrado').click(function() {
        window.location = 'Ventas/BorrarFactura.php?codigofactura=' + codigofactura;
      });

      $('.botonimprimir').click(function() {
        window.open('pdffactura.php?' + '&codigofactura=' + $(this).get(0).dataset.codigo, '_blank');
      });

    });
  </script>

</body>

</html>
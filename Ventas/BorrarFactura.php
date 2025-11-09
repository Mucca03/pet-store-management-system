<?php
  require("../ConfiguracionBD/ConexionBD.php");
  $conexion = retornarConexion();
  mysqli_query($conexion, "Delete from pedidos where nropedido=$_GET[codigofactura]");
  mysqli_query($conexion, "Delete from Ventas where nropedido=$_GET[codigofactura]");
  header('location:../Index.php');

?>
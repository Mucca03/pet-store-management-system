<?php
header('Content-Type: application/json');
require("../ConfiguracionBD/ConexionBD.php");

$conexion = retornarConexion();

$respuesta = mysqli_query($conexion, "delete from ventas where codigo=".$_GET['codigo']);
echo json_encode($respuesta);
?>

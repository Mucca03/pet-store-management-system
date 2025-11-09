<?php

header('Content-Type: application/json');
require("../ConfiguracionBD/ConexionBD.php");

$conexion = retornarConexion();

switch ($_GET['accion']) {
    case 'listar':
        $respuesta = mysqli_query($conexion, "select nit,empresa,direccion,telefono,ciudad,fecha from clientes");
        $resultado = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
    case 'agregar':
        $respuesta = mysqli_query($conexion, "insert into clientes(nit,empresa,direccion,telefono,ciudad,fecha) values ('$_POST[nit]','$_POST[empresa]','$_POST[direccion]','$_POST[telefono]','$_POST[ciudad]','$_POST[fecha]')");
        echo json_encode($respuesta);
        break;
    case 'recuperar':
        $respuesta = mysqli_query($conexion, "select nit,empresa,direccion,telefono,ciudad,fecha from clientes where nit=$_POST[nit]");
        $resultado = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);

        echo json_encode($resultado);
        break;
    case 'borrar':
        $respuesta = mysqli_query($conexion, "delete from clientes where nit=" . $_POST['nit']);
        echo json_encode($respuesta);
        break;
    case 'modificar':
        $respuesta = mysqli_query($conexion, "update clientes
                                                  set empresa='$_POST[empresa]',
                                                      direccion='$_POST[direccion]',
                                                      telefono='$_POST[telefono]',
                                                      ciudad='$_POST[ciudad]',
                                                      fecha='$_POST[fecha]'
                                                   where nit=$_POST[nit]");
        echo json_encode($respuesta);
        break;
}
?>
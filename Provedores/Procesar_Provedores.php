<?php

header('Content-Type: application/json');
require("../ConfiguracionBD/ConexionBD.php");

$conexion = retornarConexion();

switch ($_GET['accion']) {
    case 'listar':
        $respuesta = mysqli_query($conexion, "select nit,empresa,direccion,telefono from proveedores");
        $resultado = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
    case 'agregar':
        $respuesta = mysqli_query($conexion, "insert into proveedores(nit,empresa,direccion,telefono) values ('$_POST[nit]','$_POST[empresa]','$_POST[direccion]','$_POST[telefono]')");
        echo json_encode($respuesta);
        break;
    case 'recuperar':
        $respuesta = mysqli_query($conexion, "select nit,empresa,direccion,telefono from proveedores where nit=$_POST[nit]");
        $resultado = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);

        echo json_encode($resultado);
        break;
    case 'borrar':
        $respuesta = mysqli_query($conexion, "delete from proveedores where nit=" . $_POST['nit']);
        echo json_encode($respuesta);
        break;
    case 'modificar':
        $respuesta = mysqli_query($conexion, "update proveedores
                                                  set empresa='$_POST[empresa]',
                                                      direccion='$_POST[direccion]',
                                                      telefono='$_POST[telefono]'
                                                   where nit=$_POST[nit]");
        echo json_encode($respuesta);
        break;
}
?>
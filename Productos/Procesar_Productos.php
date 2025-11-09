<?php

header('Content-Type: application/json');
require("../ConfiguracionBD/ConexionBD.php");

$conexion = retornarConexion();

switch ($_GET['accion']) {
    case 'listar':
        $respuesta = mysqli_query($conexion, "select codigo,nombre,cantidad,valorunitario,categoria from productos");
        $resultado = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
    case 'agregar':
        $respuesta = mysqli_query($conexion, "insert into productos(codigo,nombre,cantidad,valorunitario,categoria) values ('$_POST[codigo]','$_POST[nombre]','$_POST[cantidad]','$_POST[valorunitario]','$_POST[categoria]')");
        echo json_encode($respuesta);
        break;
    case 'recuperar':
        $respuesta = mysqli_query($conexion, "select codigo,nombre,cantidad,valorunitario,categoria from productos where codigo=$_POST[codigo]");
        $resultado = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);

        echo json_encode($resultado);
        break;
    case 'borrar':
        $respuesta = mysqli_query($conexion, "delete from productos where codigo=" . $_POST['codigo']);
        echo json_encode($respuesta);
        break;
    case 'modificar':
        $respuesta = mysqli_query($conexion, "update productos
                                                  set nombre='$_POST[nombre]',
                                                      cantidad='$_POST[cantidad]',
                                                      valorunitario='$_POST[valorunitario]',
                                                      categoria='$_POST[categoria]'
                                                   where codigo=$_POST[codigo]");
        echo json_encode($respuesta);
        break;
    case 'listar_movimienots':
        $respuesta = mysqli_query($conexion, "SELECT v.codigo, COALESCE(p.nombre, 'Producto Desconocido') AS nombre, v.cantidadvendida, v.preciounitario, (v.cantidadvendida * v.preciounitario) AS totalventa, ped.fechaentrega AS fecha_entrega_pedido FROM Ventas v LEFT JOIN Productos p ON v.codigo = p.codigo LEFT JOIN Pedidos ped ON v.nropedido = ped.nropedido;");
        $resultado = mysqli_fetch_all($respuesta, MYSQLI_ASSOC);
        echo json_encode($resultado);
        break;
}
?>
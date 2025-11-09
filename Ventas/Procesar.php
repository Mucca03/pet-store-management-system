<?php

header('Content-Type: application/json');
require("../ConfiguracionBD/ConexionBD.php");

$conexion = retornarConexion();

switch ($_GET['accion']) {
    case 'agregar':
        //Recuperamos el precio del producto
        $respuesta = mysqli_query($conexion, "select valorunitario from productos where codigo=".$_POST['codigoproducto']);
        $registro=mysqli_fetch_array($respuesta);
        //convertir el array a string
        $resultado = implode(', ', array($registro['valorunitario']));
        $respuesta = mysqli_query($conexion, "insert into ventas(nropedido,codigo,cantidadvendida,preciounitario) values ($_GET[codigofactura],$_POST[codigoproducto],$_POST[cantidad],$resultado)");
        echo json_encode($respuesta);
        break;

    case 'confirmarfactura':
        $respuesta = mysqli_query($conexion, "update pedidos set
                                                nit='$_POST[codigocliente]',                                                
                                                fechaentrega='$_POST[fecha]',
                                                comentario='$_POST[comentario]',
                                                id_empleado='$_POST[codigoempleado]'
                                              where nropedido=$_GET[codigofactura]");
        echo json_encode($respuesta);        
        break;
    case 'confirmardescartarfactura':
        $respuesta = mysqli_query($conexion, "delete from pedidos where nropedido=$_GET[codigofactura]");
        $respuesta = mysqli_query($conexion, "delete from ventas where nropedido=$_GET[codigofactura]");
        echo json_encode($respuesta);        

}

?>
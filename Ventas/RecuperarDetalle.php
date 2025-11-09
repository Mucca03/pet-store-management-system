<?php 
  require("../ConfiguracionBD/ConexionBD.php");

  $conexion = retornarConexion();
  
  $datos = mysqli_query($conexion, "select pro.codigo as codigo,
                                            nombre,
                                            round(deta.preciounitario,2) as precio,
                                            cantidadvendida,
                                            round(deta.preciounitario*cantidadvendida,2) as preciototal,
                                            deta.codigo as coddetalle
                                        from ventas as deta
                                        join productos as pro on pro.codigo=deta.codigo
                                        where nropedido=$_GET[codigofactura]") or die(mysqli_error($conexion));

  $resultado = mysqli_fetch_all($datos, MYSQLI_ASSOC);
  $pago=0;
  foreach ($resultado as $fila) {
      echo "<tr>";
      echo "<td>$fila[codigo]</td>";
      echo "<td>$fila[nombre]</td>";      
      echo "<td class=\"text-right\">$fila[cantidadvendida]</td>";            
      echo "<td class=\"text-right\">$fila[precio]</td>";
      echo "<td class=\"text-right\">$fila[preciototal]</td>";
      echo '<td class="text-right"><a class="btn btn-primary" onclick="borrarItem('.$fila['coddetalle'].')" role="button" href="#" id="'.$fila['coddetalle'].'">Borrar</a></td>';
      echo "</tr>";      
      $pago=$pago+$fila['preciototal'];
  }
  echo "<tr>";
  echo "<td></td>";
  echo "<td></td>";      
  echo "<td></td>";            
  echo "<td class=\"text-right\"><strong>Total a pagar</strong></td>";              
  echo "<td class=\"text-right\"><strong>".number_format(round($pago,2),2,'.','')."</strong></td>";
  echo "<td></td>";            
  echo "</tr>";

?>
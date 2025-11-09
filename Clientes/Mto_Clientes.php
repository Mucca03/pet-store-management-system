<!doctype html>
<html>
    <head>
        <title>Administración Clientes</title>
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
        <?php include('../Utilitarios/Navegacion_Admin.php'); ?>  
        <div class="container">
            <h1>Administracion Clientes</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>NIT</th>
                        <th>EMPRESA</th>
                        <th>DIRECCION</th>
                        <th>TELEFONO</th>
                        <th>CIUDAD</th>
                        <th>FECHA INGRESO</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="datos">
                </tbody>
            </table>
            <button type="button" id="btnAgregar" class="btn btn-success">Nuevo</button>
            <hr>
            <button type="button" id="btnFinalizar" class="btn btn-success">Finalizar</button>
        </div>
        <div class="modal fade" id="ModalEditar" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="false">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    <!-- <input type="hidden" id="Nit" name="Nit">-->
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>NIT:</label><input type="text" id="Nit" class="form-control" placeholder="">
                            </div>
                        </div> 
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>EMPRESA:</label><input type="text" id="Empresa" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>DIRECCION:</label><input type="text" id="Direccion" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>TELEFONO:</label><input type="text" id="Telefono" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>CIUDAD:</label><input type="text" id="Ciudad" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>FECHA:</label><input type="date" id="Fecha" class="form-control" >
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnConfirmarAgregar" class="btn btn-success">Adicionar</button>
                        <button type="button" id="btnModificar" class="btn btn-success">Actualizar</button>
                        <button type="button" id="btnBorrar" class="btn btn-success">Eliminar</button>
                        <button type="button" data-dismiss="modal" class="btn btn-success">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- ModalConfirmarCancelar -->
        <div class="modal fade" id="ModalConfirmarBorrar" tabindex="-1" role="dialog">
            <div class="modal-dialog" style="max-width: 600px" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1>Seguro de eliminar el registro...?</h1>
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
            document.addEventListener("DOMContentLoaded", function () {
                var cliente;
                MostrarClientes();
                //Boton que vuelve a la página principal
                $('#btnFinalizar').click(function () {
                    window.location = '../index.php';
                });
                //Boton que muestra el diálogo de agregar
                $('#btnAgregar').click(function () {
                    LimpiarFormulario();
                    $('#btnConfirmarAgregar').show();
                    $('#btnModificar').hide();
                    $('#btnBorrar').hide();
                    $("#ModalEditar").modal();
                });
                $('#btnConfirmarAgregar').click(function () {
                    RecolectarDatosFormulario();
                    if (!EntradaFormularioCorrecto())
                        return;
                    $("#ModalEditar").modal('hide');
                    EnviarInformacion("agregar");
                });
                $('#btnBorrar').click(function () {
                    $("#ModalEditar").modal('hide');
                    $("#ModalConfirmarBorrar").modal();
                });
                $('#btnConfirmarBorrado').click(function () {
                    $("#ModalConfirmarBorrar").modal('hide');
                    RecolectarDatosFormulario();
                    $("#ModalEditar").modal('hide');
                    EnviarInformacion("borrar");
                });
                $('#btnModificar').click(function () {
                    RecolectarDatosFormulario();
                    if (!EntradaFormularioCorrecto())
                        return;
                    $("#ModalEditar").modal('hide');
                    EnviarInformacion("modificar");
                });
                //******************************************************* 
                function MostrarClientes() {
                    $.ajax({
                        type: 'GET',
                        url: 'Procesar_Clientes.php?accion=listar',
                        success: function (clientes) {
                            let filas = '';
                            for (let cliente of clientes) {
                                filas += '<tr><td>' + cliente.nit + '</td><td>' + cliente.empresa + '</td><td>' + cliente.direccion + '</td><td>' + cliente.telefono + '</td><td>' + cliente.ciudad + '</td><td>' + cliente.fecha + '</td>';
                                filas += '<td><a class="btn btn-primary botoneditar" role="button" href="#" data-nit="' + cliente.nit + '">Editar</a> </td></tr>';
                            }
                            $('#datos').html(filas);
                            //Boton que muestra el diálogo de modificar y borrar
                            $('.botoneditar').click(function () {
                                $('#Nit').val($(this).get(0).dataset.nit);
                                RecolectarDatosFormulario();
                                RecuperarCliente("recuperar");
                                $('#btnConfirmarAgregar').prop("disabled", true);
                                $('#btnConfirmarAgregar').hide();
                                $('#btnModificar').show();
                                $('#btnBorrar').show();
                                $("#ModalEditar").modal();
                            });
                        },
                        error: function () {
                            alert("Hay un error ..");
                        }
                    });
                }
                //Funciones AJAX para enviar y recuperar datos del servidor
                //******************************************************* 
                function EnviarInformacion(accion) {
                    $.ajax({
                        type: 'POST',
                        url: 'Procesar_Clientes.php?accion=' + accion,
                        data: cliente,
                        success: function (msg) {
                            MostrarClientes();
                        },
                        error: function () {
                            alert("Hay un error ..");
                        }
                    });
                }
                function RecuperarCliente(accion) {
                    $.ajax({
                        type: 'POST',
                        url: 'Procesar_clientes.php?accion=' + accion,
                        data: cliente,
                        success: function (datos) {
                            $('#Empresa').val(datos[0]['empresa']);
                            $('#Direccion').val(datos[0]['direccion']);
                            $('#Telefono').val(datos[0]['telefono']);
                            $('#Ciudad').val(datos[0]['ciudad']);
                            $('#Fecha').val(datos[0]['fecha']);
                        },
                        error: function () {
                            alert("Hay un error si..");
                        }
                    });
                }
                //******************************************************* 
                function RecolectarDatosFormulario() {
                    cliente = {
                        nit: $('#Nit').val(),
                        empresa: $('#Empresa').val(),
                        direccion: $('#Direccion').val(),
                        telefono: $('#Telefono').val(),
                        ciudad: $('#Ciudad').val(),
                        fecha: $('#Fecha').val()
                    };
                }
                function LimpiarFormulario() {
                    $('#Nit').val('');
                    $('#Empresa').val('');
                    $('#Direccion').val('');
                    $('#Telefono').val('');
                    $('#Ciudad').val('');
                    $('#Fecha').val('');
                }
                function EntradaFormularioCorrecto() {
                    if (cliente['nit'] == '') {
                        alert("No Puede estar vacío el nit de la empresa");
                        return false;
                    }
                    return true;
                }
            });
        </script>
    </body>
</html>
<?php

session_start();
if (isset($_SESSION["administrador"])) { //Condicion admin
    header("location: Menu/MenuAdministrador.php");
}
if (isset($_SESSION["empleados"])) {
    header("location: Menu/MenuEmpleados.php");
}
if (isset($_SESSION["clientes"])) {
    header("location: Menu/MenuClientes.php");
}
include '../ConfiguracionBD/ConexionBD.php';
if (isset($_REQUEST['btn_login'])) {
    $correo_usuario = $_REQUEST["correo_usuario"];
    $password = $_REQUEST["password"];
    $rol = $_REQUEST["rol"];
    if (empty($correo_usuario) or empty($password) or empty($rol) or $rol == "-Seleccione tipo de usuario-") {
        session_destroy();
        echo "<center><h2>Usuario y/o Clave y/o Rol Incorrectos</h2>";
        echo "<p><a href=../Acceso/Login.php>Volver a Inicio de Sesión</a></p></center>";
    } else {
        if ($correo_usuario AND $password AND $rol) {
            try {
                if ($rol == "admin")
                    $rol = 1;
                else if ($rol == "emp")
                    $rol = 2;
                else if ($rol == "cli")
                    $rol = 3;
                echo "usuario: " . $correo_usuario . " Clave: " . $password . " rol " . $rol;

                $objbd = new ConexionBDPDO();
                $conexion = $objbd->conectar();
                $consultasql = $conexion->prepare("Select correo,clave,idrol from usuarios where correo=:c_usuario and clave=:clave_u and idrol=:rol_u");
                $consultasql->bindParam(':c_usuario', $correo_usuario, PDO::PARAM_INT);
                $consultasql->bindParam(':clave_u', $password, PDO::PARAM_INT);
                $consultasql->bindParam(':rol_u', $rol, PDO::PARAM_INT);

                $consultasql->execute();
                $resultado = $consultasql->fetch(PDO::FETCH_ASSOC);
                if ($consultasql->rowCount() > 0) {
                    if ($resultado) {
                        switch ($rol) { //inicio de sesión de usuario base de roles
                            case 1:
                                $_SESSION["administrador"] = $correo_usuario;
                                header("location: ../Menu/MenuAdministrador.php");
                                break;
                            case 2;
                                $_SESSION["empleados"] = $correo_usuario;
                                header("location: ../Menu/MenuEmpleados.php");
                                break;
                            case 3:
                                $_SESSION["clientes"] = $correo_usuario;
                                header("location: ../Menu/MenuClientes.php");
                                break;
                            default:
                                $errorMsg[] = "correo electrónico o contraseña o rol incorrectos";
                        }
                    }
                } else {
                    session_destroy();
                    header("Location: error.php");
                }
            } catch (PDOException $e) {
                $e->getMessage();
            }
        }
    }
}
?>
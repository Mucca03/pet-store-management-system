<?php

function retornarConexion() {
    $server = "localhost";
    $usuario = "USUARIO";
    $clave = "CONTRASEÑA";
    $base = "NOMBRE_BD";

    $conexion = mysqli_connect($server, $usuario, $clave, $base) or die("problemas");
    mysqli_set_charset($conexion, 'utf8');
    return $conexion;
}

class ConexionBDPDO {

    private $host = "localhost";
    private $bd = "NOMBRE_BD";
    private $usuario = "USUARIO";
    private $clave = "CONTRASEÑA";

    function conectar() {
        try {
            $conexion = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->bd . ";charset=utf8",
                $this->usuario,
                $this->clave
            );
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $error) {
            echo 'Error conexion: ' . $error->getMessage();
            exit;
        }
    }
}

?>

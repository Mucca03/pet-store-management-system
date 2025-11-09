<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="../css/estilos.css" rel="stylesheet">   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .main {
            max-width: 800px;
            width: 100%;
        }
        .title-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .login-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .login-btn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="main">
        <div class="title-container">
            <h1>Sistema de Información Peludos ASTY</h1>
        </div>
        <div class="login-container">
            <h2 class="text-center">Bienvenido - Login</h2>
            <p class="text-center">Ingrese los datos del Login.</p>
            <form action="Validar_Login.php" method="POST">
                <div class="mb-3">
                    <label for="correo_usuario" class="form-label">Correo del Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="correo_usuario" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de usuario</label>
                    <select class="form-select" id="rol" name="rol" required>
                        <option value="" disabled selected>-Seleccione tipo de usuario-</option>
                        <option value="admin">Administrador</option>
                        <option value="emp">Empleado</option>
                        <option value="cli">Cliente</option>
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="verificacion">
                    <label class="form-check-label" for="verificacion">Recordar contraseña</label>
                </div>
                <button type="submit" name="btn_login" class="btn btn-primary login-btn w-100">Login</button>
            </form>
        </div>
    </div>    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>


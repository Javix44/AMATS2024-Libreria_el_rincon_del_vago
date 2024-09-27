<?php
$UsuarioController = new UsuarioController;
if (isset($_POST["ok"])) {
    if (!empty($_POST["username"]) && !empty($_POST["clave"])) {
        $Usuario = new Usuario("","",$_POST["username"], $_POST["clave"], "", "","");

        $_SESSION["login"] = $_POST["username"];
        $resultado = $UsuarioController->login($Usuario);
        if (empty($resultado)) {
            echo "<div class='alert alert-danger fixed-alert text-center' role='alert'>
                    <strong>Datos Incorrectos, vuelva a Intentarlo</strong>
                  </div>";
        } else {
            foreach ($resultado as $Fila) {
                if ($Fila->getEstado() == "1") {
                    if ($Fila->getEsAdmin() == "1") {
                        $_SESSION["nivel"] = "admin";
                        echo "<script>window.location.href = '';</script>";
                    } else {
                        $_SESSION["nivel"] = "cajero";
                        echo "<script>window.location.href = '';</script>";
                    }
                } else {
                    echo "<div class='alert alert-danger fixed-alert text-center' role='alert'>
                            <strong>Acceso denegado</strong>
                          </div>";
                }
            }
        }
    } else {
        echo "<div class='alert alert-danger fixed-alert text-center' role='alert'>
                <strong>Faltan Datos</strong>
              </div>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    <!-- Font Awesome for social icons -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <style>
        .fixed-alert {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            width: 80%;
            max-width: 500px;
            opacity: 0.95;
        }

        body {
            height: 100%;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .login-container {
            background-image: url('<?php echo URL ?>resources/img/fondologin1.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
        }

        .login-box {
            background-color: #191c24;
            width: 100%;
            max-width: 450px;
            margin: 70px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.5);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .form-control {
            background-color: #333;
            border: none;
            color: #fff;
            padding: 15px;
        }

        .text-white {
            color: #fff;
        }

        button {
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <div class="container-fluid login-container d-flex align-items-center justify-content-center">
        <div class="login-box p-5 rounded">
            <h2 class="text-white text-center mb-4">Libreria Rincon del Estudiante</h2>
            <form method="post">
                <div class="form-group">
                    <label for="email" class="text-white">Nombre de Usuario*</label>
                    <input type="text" class="form-control" name="username" placeholder="Ingresa tu Nombre de Usuario" required>
                </div>
                <div class="form-group">
                    <label for="password" class="text-white">Contraseña *</label>
                    <input type="password" class="form-control" name="clave" placeholder="Ingresa tu Contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-3" name="ok">Iniciar Sesion</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
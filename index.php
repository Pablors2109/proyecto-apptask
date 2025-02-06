<?php
if (isset($_POST["username"])) {
    try {
        include("conexiondb.php");
        $username = $_POST["username"];
        $password = $_POST["password"];
        
        $sql = "SELECT * FROM usuario WHERE username = :username";
        $stm = $conexion->prepare($sql);
        $stm->bindParam(":username", $username);
        $stm->execute();
        $row = $stm->fetch(PDO::FETCH_ASSOC);
        if ($row) {
           $id_usuario = $row["id_usuario"];
            if (password_verify($password, $row["password"])) {
                session_start();
                $_SESSION["username"] = $username;
                $_SESSION["id_usuario"] = $id_usuario;
                header("Location: inicio");
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } else {
            $error = "Usuario o contraseña incorrectos";
        }
    } catch (Exception $e) {
        $error = "Error al iniciar sesión, contacte con el administrador: " . $e->getMessage();
        echo "<br>";
        echo DB_USER . "  " . DB_PASS;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <form id="login-form" class="active" action="" method="post">
        <h1>Iniciar sesión apptask</h1>
        <label for="username">Nombre de usuario</label>
        <input type="text" name="username" id="username" required placeholder="Username">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" required placeholder="Password">
        <input type="submit" value="Iniciar sesión">
        <?php if (isset($error)) {
            echo "<p>" . $error . "</p>";
        }
        ?>
        <div class="button-container">
            <a href="register.php" class="button">¿No tienes una cuenta? Regístrate aquí</a>
        </div>
    </form>
</body>
</html>

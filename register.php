<?php
if (isset($_POST["register_username"])) {
    try {
        include("conexiondb.php");
        $username = $_POST["register_username"];
        $password = password_hash($_POST["register_password"], PASSWORD_BCRYPT);
        $nombre = $_POST["register_nombre"];
        $apellidos = $_POST["register_apellidos"];
        
        $sql = "INSERT INTO usuario (username, password, nombre, apellidos) VALUES (:username, :password, :nombre, :apellidos)";
        $stm = $conexion->prepare($sql);
        $stm->bindParam(":username", $username);
        $stm->bindParam(":password", $password);
        $stm->bindParam(":nombre", $nombre);
        $stm->bindParam(":apellidos", $apellidos);
        $stm->execute();

        // Log in the user
        session_start();
        $_SESSION["username"] = $username;
        $_SESSION["id_usuario"] = $conexion->lastInsertId();
        header("Location: inicio");
        exit();
    } catch (Exception $e) {
        $error = "Error al registrar usuario, contacte con el administrador: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <form id="register-form" action="" method="post">
        <h1>Registrar usuario</h1>
        <label for="register_nombre">Nombre</label>
        <input type="text" name="register_nombre" id="register_nombre" required placeholder="Nombre">
        <label for="register_apellidos">Apellidos</label>
        <input type="text" name="register_apellidos" id="register_apellidos" required placeholder="Apellidos">
        <label for="register_username">Nombre de usuario</label>
        <input type="text" name="register_username" id="register_username" required placeholder="Username">
        <label for="register_password">Contraseña</label>
        <input type="password" name="register_password" id="register_password" required placeholder="Password">
        <input type="submit" value="Registrar">
        <?php if (isset($error)) {
            echo "<p>" . $error . "</p>";
        }
        ?>
        <div class="button-container">
            <a href="index.php" class="button">¿Ya tienes una cuenta? Inicia sesión aquí</a>
        </div>
    </form>
</body>
</html>

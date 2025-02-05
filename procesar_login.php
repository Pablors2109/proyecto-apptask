<?php
include("conexiondb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id_usuario, username, pass FROM usuario WHERE username = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows == 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($password, $usuario["pass"])) {
            $_SESSION["usuario_id"] = $usuario["id_usuario"];
            $_SESSION["username"] = $usuario["username"];
            header("Location: dashboard.php");
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        header("Location: login.php?error=1");
        exit();
    }
}
?>

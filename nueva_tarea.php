<?php
if (!isset($_POST["titulo"])) {
    header("Location: nueva_tarea.php");
    exit();
}
include("conexiondb.php");

$sql = "INSERT INTO task (titulo, descripcion, fecha_creacion, estado, id_usuario) 
        VALUES (:titulo, :descripcion, :fecha_creacion, :estado, :id_usuario)";
$stm = $conexion->prepare($sql);
$stm->bindParam(":titulo", $_POST["titulo"]);
$stm->bindParam(":descripcion", $_POST["descripcion"]);
$stm->bindParam(":fecha_creacion", $_POST["fecha_creacion"]);
$stm->bindParam(":estado", $_POST["estado"]);
$stm->bindParam(":id_usuario", $id_usuario); // Asume que el id_usuario está definido previamente o puedes obtenerlo de la sesión

session_start();
$id_usuario = $_SESSION["id_usuario"];

$stm->execute();
header("Location: tarea.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Tarea</title>
    <link rel="stylesheet" href="css/tarea.css">
</head>
<body>
    <form action="" method="post">
        <h1>Introduce una nueva tarea</h1>
        <!-- ...existing code... -->
    </form>
</body>
</html>

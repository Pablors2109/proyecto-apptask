<?php
include("partials/cabecera.php"); // Incluye la cabecera y maneja la sesión y la conexión a la base de datos

// Verificar si se ha enviado un ID de tarea para editar
if (!isset($_GET['id_task'])) {
    header("Location: tarea.php"); // Redirigir si no hay ID de tarea
    exit();
}

$id_task = $_GET['id_task'];

// Obtener los datos de la tarea actual
$sql = "SELECT * FROM task WHERE id_task = :id_task AND id_usuario = :id_usuario";
$stm = $conexion->prepare($sql);
$stm->bindParam(":id_task", $id_task);
$stm->bindParam(":id_usuario", $id_usuario); // $id_usuario ya está definido en cabecera.php
$stm->execute();
$tarea = $stm->fetch(PDO::FETCH_ASSOC);

// Verificar si la tarea existe y pertenece al usuario
if (!$tarea) {
    header("Location: tarea.php"); // Redirigir si la tarea no existe o no pertenece al usuario
    exit();
}

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $estado = $_POST["estado"];

    // Actualizar la tarea en la base de datos
    $sql = "UPDATE task SET titulo = :titulo, descripcion = :descripcion, estado = :estado WHERE id_task = :id_task AND id_usuario = :id_usuario";
    $stm = $conexion->prepare($sql);
    $stm->bindParam(":titulo", $titulo);
    $stm->bindParam(":descripcion", $descripcion);
    $stm->bindParam(":estado", $estado);
    $stm->bindParam(":id_task", $id_task);
    $stm->bindParam(":id_usuario", $id_usuario);
    $stm->execute();

    header("Location: tarea.php"); // Redirigir después de editar
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarea</title>
    <link rel="stylesheet" href="css/editar_tarea.css">
</head>
<body>
    <main>
        <h1>Editar Tarea</h1>
        <form method="post">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo htmlspecialchars($tarea['titulo']); ?>" required><br>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" required><?php echo htmlspecialchars($tarea['descripcion']); ?></textarea><br>

            <!-- Eliminar la opción de editar la fecha de creación -->
            <!-- <label for="fecha_creacion">Fecha de Creación:</label>
            <input type="date" name="fecha_creacion" id="fecha_creacion" value="<?php echo htmlspecialchars($tarea['fecha_creacion']); ?>" required><br> -->

            <label for="estado">Estado:</label>
            <select name="estado" id="estado" required>
                <option value="en proceso" <?php echo ($tarea['estado'] == 'en proceso') ? 'selected' : ''; ?>>En proceso</option>
                <option value="acabada" <?php echo ($tarea['estado'] == 'acabada') ? 'selected' : ''; ?>>Acabada</option>
            </select><br>

            <input type="submit" value="Guardar Cambios">
            <a href="tarea.php">Cancelar</a>
        </form>
    </main>
</body>
</html>
<?php
include("partials/footer.php"); // Incluye el pie de página si lo tienes
?>
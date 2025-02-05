<?php
include("partials/cabecera.php"); // Incluye la cabecera y maneja la sesión y la conexión a la base de datos

// Obtener los datos del usuario actual desde la base de datos
$sql = "SELECT nombre, apellidos FROM usuario WHERE id_usuario = :id_usuario";
$stm = $conexion->prepare($sql);
$stm->bindParam(":id_usuario", $id_usuario); // $id_usuario ya está definido en cabecera.php
$stm->execute();
$usuario = $stm->fetch(PDO::FETCH_ASSOC);

// Verificar si el usuario existe
if (!$usuario) {
    header("Location: index.php"); // Redirigir si el usuario no existe
    exit();
}

// Procesar el formulario de edición
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $apellidos = $_POST["apellidos"];

    // Actualizar el nombre y apellidos del usuario en la base de datos
    $sql = "UPDATE usuario SET nombre = :nombre, apellidos = :apellidos WHERE id_usuario = :id_usuario";
    $stm = $conexion->prepare($sql);
    $stm->bindParam(":nombre", $nombre);
    $stm->bindParam(":apellidos", $apellidos);
    $stm->bindParam(":id_usuario", $id_usuario);
    $stm->execute();

    // Redirigir después de editar
    header("Location: usuario.php");
    exit();
}
?>

<main>
    <h1>Editar Perfil</h1>
    <form method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required><br>

        <label for="apellidos">Apellidos:</label>
        <input type="text" name="apellidos" id="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required><br>

        <input type="submit" value="Guardar Cambios">
        <a href="tarea.php">Cancelar</a>
    </form>
</main>

<?php
include("partials/footer.php"); // Incluye el pie de página si lo tienes
?>
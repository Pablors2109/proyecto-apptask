<?php
include("partials/cabecera.php");


$id_usuario = $_SESSION["id_usuario"];

// Verificar si se ha enviado una solicitud de borrado
if (isset($_GET['borrar_id'])) {
    $borrar_id = $_GET['borrar_id'];
    $sql = "DELETE FROM task WHERE id_task = :id_task AND id_usuario = :id_usuario";
    $stm = $conexion->prepare($sql);
    $stm->bindParam(":id_task", $borrar_id);
    $stm->bindParam(":id_usuario", $id_usuario);
    $stm->execute();
    header("Location: tarea.php"); // Redirigir para evitar reenvío del formulario
    exit();
}

$sql = "SELECT * FROM task WHERE id_usuario = :id_usuario";
$stm = $conexion->prepare($sql);
$stm->bindParam(":id_usuario", $id_usuario);
$stm->execute();
$result = $stm->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Tareas</title>
    <link rel="stylesheet" href="css/tarea.css">
</head>
<body>
    <section>
        <h3>Listado de tareas</h3>
        <?php if (!empty($result)) { ?>
        <table>
            <thead>
                <th>Titulo</th>
                <th>Fecha de creacion</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Acciones</th>
            </thead>
            <tbody>
                <?php
                foreach ($result as $row) {
                    echo "<tr>
                            <td>{$row['titulo']}</td>
                            <td>{$row['fecha_creacion']}</td>
                            <td>{$row['descripcion']}</td>
                            <td>{$row['estado']}</td>
                            <td>
                                <a href='editar_tarea.php?id_task={$row['id_task']}'>Editar</a> |
                                <a href='tarea.php?borrar_id={$row['id_task']}' onclick='return confirm(\"¿Estás seguro de que deseas borrar esta tarea?\");'>Borrar</a>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <?php } else { ?>
        <p>No hay tareas disponibles.</p>
        <?php } ?>
        <hr>
        <form action="nueva_tarea.php" method="post">
            <h1>Introduce una nueva tarea</h1>
            <label for="titulo">Titulo</label>
            <input type="text" name="titulo" id="titulo" required placeholder="Titulo">

            <label for="descripcion">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" required placeholder="Descripción">

            <label for="fecha_creacion">Fecha Creación</label>
            <input type="date" name="fecha_creacion" id="fecha_creacion" required placeholder="Fecha Creación">

            <label for="estado">Estado</label>
            <select name="estado" id="estado" required>
                <option value="en proceso">En proceso</option>
                <option value="acabada">Acabada</option>
            </select>

            <input type="submit" value="Guardar">
            <input type="reset" value="Limpiar">
        </form>
    </section>
</body>
</html>

<?php
include("partials/footer.php");
?>
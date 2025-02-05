<?php
include("partials/cabecera.php");

$sql = "select * from task where id_usuario =" . $id_usuario;
$result = $conexion->query($sql);


?>
<section>
    <h3>Listado de categorias</h3>
    <table>
        <thead>
            <th>Titulo</th>
            <th>Fecha de creacion</th>
            <th>Descripción</th>
            <th>Estado</th>

        </thead>
        <tbody>

            <?php
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        
                        <td>{$row['titulo']}</td>
                        <td>".$row['fecha_creacion']."</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['estado']}</td>
                    </tr>";
            }
            ?>
        </tbody>
    </table>
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

    </form>
</section>
    <?php
include("partials/footer.php");
?>
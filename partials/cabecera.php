<?php
session_start();
if (isset($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $id_usuario= $_SESSION["id_usuario"];
} else {
    header("Location: index");
    exit();
}
include("conexiondb.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>appTask</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/inicio.css">
</head>

<body>
    <div class="container">
        <header>
            <i class="fa-solid fa-store"></i>
            <p><?php echo $_SESSION["username"]; ?></p>
        </header>
        <main>
            <aside>
                <ul>
                    <li><a href="usuario"><i class="fa-solid fa-store"></i>Usuario</a></li>
                    <li><a href="tarea"><i class="fa-solid fa-boxes-packing"></i>Tarea</a></li>
                    
                </ul>
            </aside>
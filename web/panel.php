<?php
session_start();

// Protección: si no hay sesión, de vuelta al login
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel - Rifa</title>
</head>
<body>
    <h1>Bienvenida, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>

    <ul>
        <li><a href="rifa.php">Reservar números</a></li>
        <li><a href="buscar.php">Buscar participantes</a></li>
        <li><a href="subir_comprobante.php">Subir comprobante</a></li>
        <li><a href="archivos.php">Ver comprobantes</a></li>
        <li><a href="salir.php">Cerrar sesión</a></li>
    </ul>
</body>
</html>
<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$carpeta = __DIR__ . '/comprobantes/';
$archivos = array_diff(scandir($carpeta), ['.', '..', '.gitkeep']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobantes - Rifa</title>
</head>
<body>
    <h1>Comprobantes cargados</h1>

    <?php if (empty($archivos)): ?>
        <p>No hay comprobantes cargados todavía.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($archivos as $archivo): ?>
                <li>
                    <a href="comprobantes/<?= rawurlencode($archivo) ?>" target="_blank">
                        <?= htmlspecialchars($archivo) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <p><a href="subir_comprobante.php">Subir otro</a> | <a href="panel.php">Volver al panel</a></p>
</body>
</html>
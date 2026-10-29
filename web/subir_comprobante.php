<?php
session_start();

// Guardia de la puerta (la pauta SÍ lo exige aquí)
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$mensaje = '';
$tipo = '';   // 'ok' o 'error', para el color del mensaje

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ¿Llegó un archivo sin errores?
    if (!isset($_FILES['archivo']) || $_FILES['archivo']['error'] !== UPLOAD_ERR_OK) {
        $mensaje = 'Error: no se seleccionó un archivo o hubo un problema al subirlo.';
        $tipo = 'error';
    } else {
        $nombreOriginal = basename($_FILES['archivo']['name']);
        $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
        $permitidas = ['pdf', 'jpg', 'jpeg', 'png'];

        if (!in_array($extension, $permitidas)) {
            $mensaje = 'Error: solo se permiten archivos PDF, JPG o PNG.';
            $tipo = 'error';
        } elseif ($_FILES['archivo']['size'] > 5 * 1024 * 1024) {
            $mensaje = 'Error: el archivo no puede pesar más de 5 MB.';
            $tipo = 'error';
        } else {
            // Se agrega la fecha y hora al nombre para no pisar archivos con el mismo nombre
            $nombreFinal = date('Ymd_His') . '_' . $nombreOriginal;
            $destino = __DIR__ . '/comprobantes/' . $nombreFinal;

            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $destino)) {
                $mensaje = 'Archivo cargado correctamente: ' . htmlspecialchars($nombreFinal);
                $tipo = 'ok';
            } else {
                $mensaje = 'Error: no se pudo guardar el archivo en el servidor.';
                $tipo = 'error';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir comprobante - Rifa</title>
</head>
<body>
    <h1>Subir comprobante</h1>

    <?php if ($mensaje): ?>
        <p style="color:<?= $tipo === 'ok' ? 'green' : 'red' ?>;"><?= $mensaje ?></p>
    <?php endif; ?>

    <!-- enctype es OBLIGATORIO para poder enviar archivos -->
    <form method="POST" action="subir_comprobante.php" enctype="multipart/form-data">
        <input type="file" name="archivo" required><br><br>
        <button type="submit">Subir</button>
    </form>

    <p><a href="archivos.php">Ver comprobantes</a> | <a href="panel.php">Volver al panel</a></p>
</body>
</html>
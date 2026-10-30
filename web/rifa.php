<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$precio = 2000;

if (!isset($_SESSION['reservados'])) {
    $_SESSION['reservados'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cantidad = (int)($_POST['cantidad'] ?? 0);
    $accion   = $_POST['accion'] ?? '';

    if ($cantidad < 1) {
        $_SESSION['mensaje'] = 'La cantidad debe ser 1 o más.';
    } elseif ($accion === 'agregar') {
        $_SESSION['reservados'] += $cantidad;
    } elseif ($accion === 'quitar') {
        if ($cantidad > $_SESSION['reservados']) {
            $_SESSION['mensaje'] = 'No puedes quitar más números de los que tienes reservados.';
        } else {
            $_SESSION['reservados'] -= $cantidad;
        }
    }

    header('Location: rifa.php');
    exit;
}

$mensaje = $_SESSION['mensaje'] ?? '';
unset($_SESSION['mensaje']);

$reservados = $_SESSION['reservados'];
$total = $reservados * $precio;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reserva de números - Rifa</title>
</head>
<body>
    <h1>Reserva de números</h1>

    <?php if ($mensaje): ?>
        <p style="color:red;"><?= $mensaje ?></p>
    <?php endif; ?>

    <p>Números reservados: <strong><?= $reservados ?></strong></p>
    <p>Precio por número: <strong>$<?= number_format($precio, 0, ',', '.') ?></strong></p>
    <p>Total a pagar: <strong>$<?= number_format($total, 0, ',', '.') ?></strong></p>

    <form method="POST" action="rifa.php">
        <label>Cantidad:</label>
        <input type="number" name="cantidad" value="1" min="1" required>
        <button type="submit" name="accion" value="agregar">Agregar</button>
        <button type="submit" name="accion" value="quitar">Quitar</button>
    </form>

    <p><a href="panel.php">Volver al panel</a></p>
</body>
</html>
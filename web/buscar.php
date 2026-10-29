<?php
session_start();

// Guardia de la puerta (la pauta no lo exige aquí, pero queda consistente con el panel)
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

// Participantes definidos previamente (mínimo 4, uno con los datos de la pauta)
$participantes = [
    ['nombre' => 'Universidad', 'apellido' => 'Playa Ancha', 'ciudad' => 'Valparaiso',  'categoria' => 'Grupo A'],
    ['nombre' => 'Camila',      'apellido' => 'Rojas',       'ciudad' => 'Viña del Mar', 'categoria' => 'Grupo B'],
    ['nombre' => 'Matías',      'apellido' => 'Soto',        'ciudad' => 'Quilpué',      'categoria' => 'Grupo A'],
    ['nombre' => 'Fernanda',    'apellido' => 'Muñoz',       'ciudad' => 'Santiago',     'categoria' => 'Grupo C'],
];

// Leer lo que viene por GET (si no viene nada, queda vacío)
$nombre    = trim($_GET['nombre'] ?? '');
$apellido  = trim($_GET['apellido'] ?? '');
$ciudad    = trim($_GET['ciudad'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');

$resultado = '';

// Solo buscar si se envió el formulario
if (isset($_GET['nombre'])) {
    $encontrado = false;

    foreach ($participantes as $p) {
        // Tienen que coincidir LAS 4 condiciones (sin importar mayúsculas/minúsculas)
        if (mb_strtolower($p['nombre'])    === mb_strtolower($nombre) &&
            mb_strtolower($p['apellido'])  === mb_strtolower($apellido) &&
            mb_strtolower($p['ciudad'])    === mb_strtolower($ciudad) &&
            mb_strtolower($p['categoria']) === mb_strtolower($categoria)) {
            $encontrado = true;
            break;   // ya lo encontramos, no hace falta seguir buscando
        }
    }

    $resultado = $encontrado ? 'Participante encontrado' : 'Participante no encontrado';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscar participante - Rifa</title>
</head>
<body>
    <h1>Buscar participante</h1>

    <form method="GET" action="buscar.php">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" value="<?= htmlspecialchars($nombre) ?>" required><br><br>

        <label>Apellido:</label><br>
        <input type="text" name="apellido" value="<?= htmlspecialchars($apellido) ?>" required><br><br>

        <label>Ciudad:</label><br>
        <input type="text" name="ciudad" value="<?= htmlspecialchars($ciudad) ?>" required><br><br>

        <label>Categoría:</label><br>
        <input type="text" name="categoria" value="<?= htmlspecialchars($categoria) ?>" required><br><br>

        <button type="submit">Buscar</button>
    </form>

    <?php if ($resultado): ?>
        <h2><?= $resultado ?></h2>
    <?php endif; ?>

    <p><a href="panel.php">Volver al panel</a></p>
</body>
</html>
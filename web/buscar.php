<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit;
}

$participantes = [
    ['nombre' => 'Universidad', 'apellido' => 'Playa Ancha', 'ciudad' => 'Valparaiso',  'categoria' => 'Grupo A'],
    ['nombre' => 'josefa',      'apellido' => 'rojas',       'ciudad' => 'Viña del Mar', 'categoria' => 'Grupo B'],
    ['nombre' => 'patricio',      'apellido' => 'soto',        'ciudad' => 'Quilpué',      'categoria' => 'Grupo A'],
    ['nombre' => 'fernanda',    'apellido' => 'muñoz',       'ciudad' => 'Santiago',     'categoria' => 'Grupo C'],
];

$nombre    = trim($_GET['nombre'] ?? '');
$apellido  = trim($_GET['apellido'] ?? '');
$ciudad    = trim($_GET['ciudad'] ?? '');
$categoria = trim($_GET['categoria'] ?? '');

$resultado = '';

if (isset($_GET['nombre'])) {
    $encontrado = false;

    foreach ($participantes as $p) {
        if (mb_strtolower($p['nombre'])    === mb_strtolower($nombre) &&
            mb_strtolower($p['apellido'])  === mb_strtolower($apellido) &&
            mb_strtolower($p['ciudad'])    === mb_strtolower($ciudad) &&
            mb_strtolower($p['categoria']) === mb_strtolower($categoria)) {
            $encontrado = true;
            break; 
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
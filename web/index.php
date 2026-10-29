 <?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: panel.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario   = trim($_POST['usuario'] ?? '');
    $clave     = $_POST['clave'] ?? '';
    $respuesta = $_POST['captcha'] ?? '';

    $captchaOk = isset($_SESSION['captcha'])
                 && is_numeric($respuesta)
                 && (int)$respuesta === $_SESSION['captcha'];

    if ($usuario === 'userupla' && $clave === 'upla123' && $captchaOk) {
        session_regenerate_id(true);    
        $_SESSION['usuario'] = $usuario;   
        header('Location: panel.php');
        exit;
    } else {
        $error = 'Usuario, contraseña o CAPTCHA incorrectos.';
    }
}

$n1 = rand(1, 10);
$n2 = rand(1, 10);
$_SESSION['captcha'] = $n1 + $n2; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Rifa</title>
</head>
<body>
    <h1>Iniciar sesión</h1>

    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>

    <form method="POST" action="index.php">
        <label>Usuario:</label><br>
        <input type="text" name="usuario" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="clave" required><br><br>

        <label>CAPTCHA: ¿Cuánto es <?= $n1 ?> + <?= $n2 ?>?</label><br>
        <input type="number" name="captcha" required><br><br>

        <button type="submit">Ingresar</button>
    </form>
</body>
</html>
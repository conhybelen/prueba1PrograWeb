<?php
session_start();

// 1. Vaciar todas las variables de sesión
$_SESSION = [];

// 2. Borrar la cookie de la sesión del navegador
if (ini_get('session.use_cookies')) {
    $p = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $p['path'], $p['domain'], $p['secure'], $p['httponly']);
}

// 3. Destruir la sesión en el servidor
session_destroy();

// 4. Volver al login
header('Location: index.php');
exit;
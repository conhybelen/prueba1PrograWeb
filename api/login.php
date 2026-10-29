<?php
require 'funciones.php';
verificarMetodo('POST');

$datos   = datosEntrada();
$usuario = trim($datos['usuario'] ?? '');
$clave   = $datos['clave'] ?? '';

if ($usuario === '' || $clave === '') {
    responder(400, ['error' => 'Debe enviar usuario y clave.']);
}

if ($usuario === 'userupla' && $clave === 'upla123') {
    session_regenerate_id(true);
    $_SESSION['usuario_api'] = $usuario;
    responder(200, ['mensaje' => 'Sesión iniciada correctamente.', 'usuario' => $usuario]);
}

responder(401, ['error' => 'Usuario o contraseña incorrectos.']);
<?php
session_start();

header('Content-Type: application/json; charset=utf-8');

function responder($codigo, $datos) {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function verificarMetodo($metodo) {
    if ($_SERVER['REQUEST_METHOD'] !== $metodo) {
        responder(405, ['error' => "Método no permitido. Use $metodo."]);
    }
}

function verificarSesion() {
    if (!isset($_SESSION['usuario_api'])) {
        responder(401, ['error' => 'No autorizado. Debe iniciar sesión.']);
    }
}


function leerJson($archivo) {
    $ruta = __DIR__ . '/' . $archivo;
    if (!file_exists($ruta)) {
        return [];
    }
    $datos = json_decode(file_get_contents($ruta), true);
    return is_array($datos) ? $datos : [];
}

function guardarJson($archivo, $datos) {
    $ruta = __DIR__ . '/' . $archivo;
    file_put_contents($ruta, json_encode(array_values($datos), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

function datosEntrada() {
    if (!empty($_POST)) {
        return $_POST;
    }
    $json = json_decode(file_get_contents('php://input'), true);
    return is_array($json) ? $json : [];
}
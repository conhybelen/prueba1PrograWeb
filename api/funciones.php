<?php
session_start();

// Todas las respuestas de la API son JSON
header('Content-Type: application/json; charset=utf-8');

// Envía una respuesta JSON con su código HTTP y termina
function responder($codigo, $datos) {
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// Revisa que se use el método correcto (GET o POST)
function verificarMetodo($metodo) {
    if ($_SERVER['REQUEST_METHOD'] !== $metodo) {
        responder(405, ['error' => "Método no permitido. Use $metodo."]);
    }
}

// "Guardia de la puerta" de la API: si no hay sesión, responde 401
function verificarSesion() {
    if (!isset($_SESSION['usuario_api'])) {
        responder(401, ['error' => 'No autorizado. Debe iniciar sesión.']);
    }
}

// Lee un archivo JSON y lo devuelve como arreglo de PHP
function leerJson($archivo) {
    $ruta = __DIR__ . '/' . $archivo;
    if (!file_exists($ruta)) {
        return [];
    }
    $datos = json_decode(file_get_contents($ruta), true);
    return is_array($datos) ? $datos : [];
}

// Guarda un arreglo de PHP en un archivo JSON
function guardarJson($archivo, $datos) {
    $ruta = __DIR__ . '/' . $archivo;
    file_put_contents($ruta, json_encode(array_values($datos), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}

// Lee los datos enviados por POST (sirve tanto con formulario como con JSON)
function datosEntrada() {
    if (!empty($_POST)) {
        return $_POST;
    }
    $json = json_decode(file_get_contents('php://input'), true);
    return is_array($json) ? $json : [];
}
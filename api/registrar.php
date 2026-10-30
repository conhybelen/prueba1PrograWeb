<?php
require 'funciones.php';
verificarMetodo('POST');
verificarSesion();

$datos    = datosEntrada();
$nombre   = trim($datos['nombre'] ?? '');
$apellido = trim($datos['apellido'] ?? '');
$numero   = trim((string)($datos['numero_rifa'] ?? ''));

if ($nombre === '' || $apellido === '' || $numero === '') {
    responder(400, ['error' => 'Debe enviar nombre, apellido y numero_rifa.']);
}
if (!ctype_digit($numero) || (int)$numero < 1) {
    responder(400, ['error' => 'numero_rifa debe ser un número entero positivo.']);
}

$lista = leerJson('participantes.json');

foreach ($lista as $p) {
    if ((int)$p['numero_rifa'] === (int)$numero) {
        responder(409, ['error' => 'Ese número de rifa ya está ocupado.']);
    }
}

$nuevoId = empty($lista) ? 1 : max(array_column($lista, 'id')) + 1;

$nuevo = [
    'id'          => $nuevoId,
    'nombre'      => $nombre,
    'apellido'    => $apellido,
    'numero_rifa' => (int)$numero,
];

$lista[] = $nuevo;
guardarJson('participantes.json', $lista);

responder(201, ['mensaje' => 'Participante registrado.', 'participante' => $nuevo]);
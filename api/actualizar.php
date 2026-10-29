<?php
require 'funciones.php';
verificarMetodo('POST');
verificarSesion();

$datos = datosEntrada();
$id = (int)($datos['id'] ?? 0);

if ($id < 1) {
    responder(400, ['error' => 'Debe enviar un id válido.']);
}

$lista = leerJson('participantes.json');

// Buscar la posición del participante con ese ID
$posicion = null;
foreach ($lista as $i => $p) {
    if ((int)$p['id'] === $id) {
        $posicion = $i;
        break;
    }
}

if ($posicion === null) {
    responder(404, ['error' => "No existe un participante con id $id."]);
}

// Solo se cambia lo que venga en la petición
if (isset($datos['nombre']) && trim($datos['nombre']) !== '') {
    $lista[$posicion]['nombre'] = trim($datos['nombre']);
}
if (isset($datos['apellido']) && trim($datos['apellido']) !== '') {
    $lista[$posicion]['apellido'] = trim($datos['apellido']);
}
if (isset($datos['numero_rifa']) && trim((string)$datos['numero_rifa']) !== '') {
    $numero = trim((string)$datos['numero_rifa']);
    if (!ctype_digit($numero) || (int)$numero < 1) {
        responder(400, ['error' => 'numero_rifa debe ser un número entero positivo.']);
    }
    foreach ($lista as $p) {
        if ((int)$p['numero_rifa'] === (int)$numero && (int)$p['id'] !== $id) {
            responder(409, ['error' => 'Ese número de rifa ya está ocupado por otro participante.']);
        }
    }
    $lista[$posicion]['numero_rifa'] = (int)$numero;
}

guardarJson('participantes.json', $lista);

responder(200, ['mensaje' => 'Participante actualizado.', 'participante' => $lista[$posicion]]);
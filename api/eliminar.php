<?php
require 'funciones.php';
verificarMetodo('GET');
verificarSesion();

$id = (int)($_GET['id'] ?? 0);

if ($id < 1) {
    responder(400, ['error' => 'Debe enviar un id válido. Ejemplo: eliminar.php?id=2']);
}

$lista = leerJson('participantes.json');

foreach ($lista as $i => $p) {
    if ((int)$p['id'] === $id) {
        $eliminado = $p;
        unset($lista[$i]);
        guardarJson('participantes.json', $lista);
        responder(200, ['mensaje' => 'Participante eliminado.', 'participante' => $eliminado]);
    }
}

responder(404, ['error' => "No existe un participante con id $id."]);
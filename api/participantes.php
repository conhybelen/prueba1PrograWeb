<?php
require 'funciones.php';
verificarMetodo('GET');
verificarSesion();

responder(200, leerJson('participantes.json'));
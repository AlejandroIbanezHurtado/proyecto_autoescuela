<?php
require "../cargadores/cargarBD.php";
BD::Conectar();
$a = BD::obtenPreguntasPaginados($_GET['pagina'], $_GET['filas']);
echo json_encode($a);
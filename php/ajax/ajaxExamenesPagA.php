<?php
require "../cargadores/cargarBD.php";
BD::Conectar();
$a = BD::obtenExamenesPaginadosA($_GET['pagina'], $_GET['filas']);
echo json_encode($a);
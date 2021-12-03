<?php
require "../cargadores/cargarBD.php";
BD::Conectar();
$a = BD::obtenUsuariosPaginados(1, 2);
echo json_encode($a);
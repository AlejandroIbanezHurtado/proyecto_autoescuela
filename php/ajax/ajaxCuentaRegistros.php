<?php
require "../cargadores/cargarBD.php";
BD::Conectar();
$a = BD::cuentaRegistros($_GET['tabla']);
echo json_encode($a);
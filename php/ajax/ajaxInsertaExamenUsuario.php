<?php
require "../cargadores/cargarEntidades.php";
require "../cargadores/cargarBD.php";
BD::Conectar();
$examenUsuario = json_decode($_POST['examenUsuario']);
$examen = new examen($examenUsuario->examen->id, $examenUsuario->examen->descripcion, $examenUsuario->examen->duracion, $examenUsuario->examen->num_preguntas, $examenUsuario->examen->activo);
$usuario = BD::selectUsuarioEmail2($examenUsuario->usuario);
$ejecucion = $examenUsuario->ejecucion;
$resul = new examen_usuario(null, $examen, $usuario, null, $examenUsuario->calificacion, $ejecucion);
var_dump(BD::insertarExamenUsuario($resul));
<?php
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
BD::Conectar();
switch($_GET['tabla'])
{
    case "usuarios":
        $usuario = BD::selectUsuarioId($_GET['valor']);
        var_dump(BD::borrarUsuarioId($usuario));
        break;
    case "tematica":
        $tematica = new tematica($_GET['valor'],null);
        var_dump($tematica);
        BD::borrarTematicaId($tematica);
        break;
    case "preguntas":
        $pregunta = new pregunta($_GET['valor'], null, null, null, null, null);
        var_dump(BD::borrarPreguntaId($pregunta));
        break;
    case "examen":
        $examen = new examen($_GET['valor'], null, null, null, null);
        BD::borrarExamenId($examen);
        break;
}
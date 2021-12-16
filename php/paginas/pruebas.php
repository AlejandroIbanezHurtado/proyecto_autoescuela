<?php
require "../cargadores/cargarEntidades.php";
require "../cargadores/cargarHelper.php";
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarBD.php";
require "../helper/correo.php";
session_start();
var_dump($_SESSION);
$tematica = new tematica(null,"tema");
BD::Conectar();
var_dump(var_dump($tematica));
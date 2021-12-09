<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
Sesion::inserta("editarPregunta",$_GET['tematica']);

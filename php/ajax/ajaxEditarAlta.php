<?php
require "../cargadores/cargarSesion.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
Sesion::inserta("editar".$_GET['tabla'],$_GET['valor']);

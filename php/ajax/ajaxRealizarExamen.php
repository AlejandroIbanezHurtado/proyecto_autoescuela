<?php
require "../cargadores/cargarSesion.php";
Sesion::abreSesion();
Sesion::inserta("realizaExamen",$_GET['valor']);
<?php
require "../cargadores/cargarSesion.php";
Sesion::abreSesion();
unset($_SESSION['usuario']);

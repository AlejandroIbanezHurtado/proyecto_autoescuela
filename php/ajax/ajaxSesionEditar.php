<?php
require "../cargadores/cargarSesion.php";
Sesion::abreSesion();
if(isset($_SESSION['editar']))
{
    echo "editar";
}
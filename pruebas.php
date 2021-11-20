<?php
include("bd/bd.php");

BD::Conectar();
var_dump(BD::selectUsuario());

echo "<a href='login.php'>Inicio</a>";
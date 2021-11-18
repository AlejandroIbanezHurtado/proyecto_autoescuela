<?php
include("bd/tematica-bd.php");
tematica_bd::Conectar();
tematica_bd::borrarTematicaId("1");
$vector = tematica_bd::selectTematica();
var_dump($vector);
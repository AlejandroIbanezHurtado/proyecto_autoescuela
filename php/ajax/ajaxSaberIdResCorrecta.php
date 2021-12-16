<?php
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
BD::Conectar();

$vector = json_decode($_POST['vector']);
$resCor = [];
foreach ($vector as &$valor) {
    $resCor[]=BD::selectPreguntaId($valor)[$valor]->getId_respuesta_correcta()->getId();
}
echo json_encode($resCor);

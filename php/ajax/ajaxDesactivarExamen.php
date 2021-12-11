<?php
require "../cargadores/cargarBD.php";
BD::Conectar();
BD::desactivaExamen($_GET['valor'],$_GET['activo']);
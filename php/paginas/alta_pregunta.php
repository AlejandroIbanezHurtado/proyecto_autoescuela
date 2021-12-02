<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta pregunta</title>
    <?php
    require "../cargadores/cargarEntidades.php";
    require "../cargadores/cargarBD.php";
    require "../cargadores/cargarSesion.php";
    require "../cargadores/cargarHelper.php";
    Sesion::abreSesion();
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
    <script src="../../js/lib/lib-altaPregunta.js"></script>
</head>
<body>
    <img src="../../archivos/imagenesWeb/imagenLarga.png" alt="Logo autoescuela" class="fotoAutoescuela">
    <img src="../../archivos/imagenesWeb/user.png" alt="Imagen usuario" class="fotoUsuario">
    <nav>
        <ul>
            <li class="categoria">
                <a href="#">Usuarios</a>
                <ul class="submenu">
                    <li><a href="alta_usuario.php">Alta de usuario</a></li>
                    <li><a href="#">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="#">Temáticas</a>
                <ul class="submenu">
                    <li><a href="alta_tematica.php">Alta temática</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="#">Preguntas</a>
                <ul class="submenu">
                    <li><a href="alta_pregunta.php">Alta pregunta</a></li>
                    <li><a href="#">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="#">Exámenes</a>
                <ul class="submenu">
                    <li><a href="../../js/paginas/alta_examen.html">Alta examen</a></li>
                    <li><a href="#">Histórico</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <h3>Alta pregunta</h3>
    
    <form method="post" class="formAltaPreg" enctype="multipart/form-data">
        <label class="imagenAlta" id="imagenPre">
                <input type="file" accept="image/png, image/gif, image/jpeg" name="fichero" id="subir"/>
        </label>
        <label for="tematica">Temática</label><br>
        <?php
            echo "<select name=\"tematica\" id=\"tematica\">";
            BD::Conectar();
            $tematicas = BD::selectTematica();
            foreach($tematicas as &$tem)
            {
                echo "<option value='".$tem->getId()."'>";
                echo $tem->getTema();
                echo "</option>";
                
            }
            echo "</select>";
        ?>
        <br>
        <label for="enunciado">Enunciado</label><br>
        <textarea name="enunciado" id="enunciado" cols="30" rows="10" class="errorInputenunciado"><?php echo isset($_POST['enunciado']) ? $_POST['enunciado'] : '' ?></textarea>
        <section id="res1">
            <input type="text" placeholder="opcion 1" name="respuesta1" class="errorInputrespuesta1" value="<?php echo isset($_POST['respuesta1']) ? $_POST['respuesta1'] : '' ?>">
            <input type="radio" name="correcta" id="correcta1" value="1" checked><label for="correcta1">Correcta</label>
        </section>
        <section id="res2">
            <input type="text" placeholder="opcion 2" id="correcta2" name="respuesta2" class="errorInputrespuesta2" value="<?php echo isset($_POST['respuesta2']) ? $_POST['respuesta2'] : '' ?>">
            <input type="radio" name="correcta" value="2"><label for="correcta2">Correcta</label>
        </section>
        <section id="res3">
            <input type="text" placeholder="opcion 3" id="correcta3" name="respuesta3" class="errorInputrespuesta3" value="<?php echo isset($_POST['respuesta3']) ? $_POST['respuesta3'] : '' ?>">
            <input type="radio" name="correcta" value="3"><label for="correcta3">Correcta</label>
        </section>
        <section id="res4">
            <input type="text" placeholder="opcion 4" id="correcta4" name="respuesta4" class="errorInputrespuesta4" value="<?php echo isset($_POST['respuesta4']) ? $_POST['respuesta4'] : '' ?>">
            <input type="radio" name="correcta" value="4"><label for="correcta4">Correcta</label>
        </section>
        <input type="submit" name="guardar" value="Guardar" id="guardar" class="botones">
    </form>
    <?php
    $archivo = null;
    if(isset($_POST['guardar']))
    {
        if($_FILES['fichero']['size']!=0)
        {
            $archivo = $_FILES['fichero'];
        }
        
        //GUARDAMOS
        
        //VALIDAMOS LOS CAMPOS DE PREGUNTA
        $enunciado = BD::selectPreguntaEnunciado($_POST['enunciado']);//vemos si ese enunciado existe en la base de datos
        $p = new pregunta(null, $_POST['enunciado'], null, null, null, [$_POST['respuesta1'],$_POST['respuesta2'],$_POST['respuesta3'],$_POST['respuesta4']]);
        $res = validator::validaAltaPregunta($p);
        if(count($res)!=0)
        {
            $indices = [];
            $indices = array_keys($res);
            foreach($indices as &$valor)
            {
                echo "<style>.errorInput${valor}{border-color: red;}</style>";//mostramos bordes en rojo en los campos erroneos
            }
        }
        else{
            if($archivo!=null)
            {
                // archivo = ruta donde se ha guardado
                $tipo = $archivo['type'];
                $tipo = substr($tipo, 6, 10);
                $nombre = "imagen".(rand(0, 100) + rand(0, 10000)).$archivo['size'];
                move_uploaded_file($archivo['tmp_name'],"../../archivos/imagenesPreguntas/".$nombre.".".$tipo);
                $archivo = "../../archivos/imagenesPreguntas/".$nombre.".".$tipo;
            }
            //creamos pregunta sin array de respuestas ni respuesta correcta y lo insertamos en la base de datos
            $pregunta = new pregunta(null, $_POST['enunciado'], null, $archivo, $_POST['tematica'], null);
            BD::insertarPregunta($pregunta);
            //creamos respuestas asociadas a esa pregunta recien creada
            $id_pregunta = BD::selectPreguntaEnunciadoPeq($_POST['enunciado']);
            //var_dump($id_pregunta);
            //insert de respuestas
            $pregunta->setId($id_pregunta);
            for($i=1;$i<5;$i++)
            {
                $respuesta = new respuesta(null,$_POST['respuesta'.$i],$pregunta);
                BD::insertarRespuesta($respuesta);
            }
            //update para respuesta correcta
            $num = $_POST['correcta'];
            $respuesta = new respuesta(null,$_POST['respuesta'.$num],$pregunta);
            $id_res = BD::selectRespuestaEnunciadoPeq($respuesta->getEnunciado(), $pregunta->getId());
            BD::actualizaRespuestaCorrecta($id_res, $pregunta->getId());
        }
        
    }
    ?>
</body>
</html>
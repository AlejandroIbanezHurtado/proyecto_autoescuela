<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta tematica</title>
    <?php
        require "../cargadores/cargarEntidades.php";
        require "../cargadores/cargarHelper.php";
        require "../cargadores/cargarSesion.php";
        require "../cargadores/cargarBD.php";
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
    <script src="../../js/lib/lib-botonLogin.js"></script>
</head>
<body>
    <img src="../../archivos/imagenesWeb/imagenLarga.png" alt="Logo autoescuela" class="fotoAutoescuela">
    <img src="../../archivos/imagenesWeb/user.png" alt="Imagen usuario" class="fotoUsuario"><aside class="ocultar" id="cajaUser"><a href="#">Editar</a><br><br><a href="#" id="cierraSesion">Cerrar sesión</a></aside>
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
    <h3>Alta tematica</h3>
    <form method="post" class="formAltaUsuario">
        <label for="tema">Tema:</label><br>
        <input type="text" id="tema" name="tema" class="errorInputtema" value="<?php echo isset($_POST['tema']) ? $_POST['tema'] : '' ?>"><br>
        <input type="submit" name="btnGuardar" value="Guardar" class="botones">
    </form>
    <?php
    if(!isset($_SESSION))
    {
        Sesion::abreSesion();
    }
    if(isset($_SESSION['usuario']))
    {
        BD::Conectar();
        $usuario = BD::selectUsuarioEmail2($_SESSION['usuario']->getCorreo());
        if($usuario->getRol()=="alumno")
        {
            header('Location: login.php');
        }
        else{
            if(isset($_POST['btnGuardar']))
            {
                $tematica = new tematica(null,$_POST['tema']);
                $res = Validator::validaTematica($tematica);
                if(count($res)!=0)
                {
                    $indices = [];
                    $indices = array_keys($res);
                    foreach($indices as &$valor)
                    {
                        echo "<style>.errorInput${valor}{border-color: red;}</style>";
                    }
                }
                else{
                    $tematica = new tematica(null,$_POST['tema']);
                    BD::insertarTematica($tematica);
                }
            }
        }
    }
    else{
        header('Location: login.php');
    }
    

    ?>
</body>
</html>
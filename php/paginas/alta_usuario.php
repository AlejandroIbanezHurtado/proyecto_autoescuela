<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta usuario</title>
    <?php
        require "../cargadores/cargarEntidades.php";
        require "../cargadores/cargarHelper.php";
        require "../cargadores/cargarSesion.php";
        require "../cargadores/cargarBD.php";
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
    <script src="../../js/lib/lib-botonLogin.js"></script>
    <script src="../../js/lib/lib-altaPregunta.js"></script>
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
    <h3>Alta usuario</h3>
    <form method="post" class="formAltaUsuario" enctype="multipart/form-data">
        <label class="imagenAlta" id="imagenPre">
                <input type="file" accept="image/png, image/gif, image/jpeg" name="fichero" id="subir"/>
        </label>
        EMAIL:<br>
        <input type="mail" name="email" id="email" class="errorInputemail" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
        <br>
        NOMBRE:<br>
        <input type="text" name="nombre" id="nombre" class="errorInputnombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : '' ?>">
        <br>
        APELLIDOS:<br>
        <input type="text" name="apellidos" id="apellidos" class="errorInputapellidos" value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : '' ?>">
        <br>
        FECHA DE NACIMIENTO:<br>
        <input type="date" name="fechaNac" id="fechaNac" class="errorInputfechaNac" value="<?php echo isset($_POST['fechaNac']) ? $_POST['fechaNac'] : '' ?>">
        <br>
        ROL:<br>
        <select name="rol">
            <option value="alumno" selected>alumno</option>
            <option value="administrador">administrador</option>
        </select>
        <br><br>
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
            $archivo = null;
            if(isset($_POST['btnGuardar']))
            {
                if(!empty($_FILES))
                {
                    if($_FILES['fichero']['size']!=0)
                    {
                        $archivo = $_FILES['fichero'];
                    }
                }
                $password=rand(10000000, 99999999);//generamos una contraseña aleatoria por defecto
                
                $usuario = new usuario("", $_POST['email'], $_POST['nombre'], $_POST['apellidos'],$password, $_POST['fechaNac'], $_POST['rol'], null);
                $res = validator::validaAltaUsuario($usuario);
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
                    if($archivo!=null)
                    {
                        // archivo = ruta donde se ha guardado
                        $tipo = $archivo['type'];
                        $tipo = substr($tipo, 6, 10);
                        $nombre = "imagen".(rand(0, 100) + rand(0, 10000)).$archivo['size'];
                        move_uploaded_file($archivo['tmp_name'],"../../archivos/imagenesUsuarios/".$nombre.".".$tipo);
                        $archivo = "../../archivos/imagenesUsuarios/".$nombre.".".$tipo;
                    }
                    $usuario->setImagen($archivo);
                    Sesion::inserta("usuarioCorreo",$usuario);
                    $id = (rand(0,5000) + time());
                    $mensaje = "Bienvenido a Autoescuela Alc&aacute;zar <br>Haz click en el siguiente enlace pra cambiar tu contrase&ntilde;a y as&iacute; confirmar tu registro<br><br><a href=\"http://localhost/autoescuela/php/paginas/cambiaPassword.php?id=${id}\">Aqu&iacute;</a>";
                    Sesion::inserta("mensaje",$mensaje);
                    Sesion::inserta("id",$id);
                    header('Location: enviaCorreo.php');
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
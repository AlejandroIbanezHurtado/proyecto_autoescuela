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
        if(!isset($_SESSION))
        {
            Sesion::abreSesion();
        }
        if(isset($_SESSION['usuario']))
        {
            BD::Conectar();
            $usuario = BD::selectUsuarioEmail2($_SESSION['usuario']->getCorreo());
        }
        if(isset($_SESSION['editarUsuario']) && is_numeric($_SESSION['editarUsuario']))
        {
            $usuario = BD::selectUsuarioId($_SESSION['editarUsuario']);
            $_SESSION['editarUsuario'] = $usuario->getCorreo();
        }
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
    <script src="../../js/lib/lib-botonLogin.js"></script>
    <script src="../../js/lib/lib-altaPregunta.js"></script>
    <script src="../../js/lib/lib-loginHistorico.js"></script>
    <!-- <script>window.onbeforeunload = alert("");</script> -->
</head>
<body>
    <img src="../../archivos/imagenesWeb/imagenLarga.png" alt="Logo autoescuela" class="fotoAutoescuela">
    <img src="../../archivos/imagenesWeb/user.png" alt="Imagen usuario" class="fotoUsuario"><aside class="ocultar" id="cajaUser"><a href="#" id="editar">Editar</a><br><br><a href="#" id="cierraSesion">Cerrar sesión</a></aside>
    <!-- NAV ADMINISTRADOR -->
    <nav>
        <ul>
            <li class="categoria">
                <a href="../../js/paginas/listado_usuarios.html">Usuarios</a>
                <ul class="submenu">
                    <li><a href="../../php/paginas/alta_usuario.php">Alta de usuario</a></li>
                    <li><a href="../../js/paginas/alta_masiva_usuarios.html">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../../js/paginas/listado_tematicas.html">Temáticas</a>
                <ul class="submenu">
                    <li><a href="../../php/paginas/alta_tematica.php">Alta temática</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../../js/paginas/listado_preguntas.html">Preguntas</a>
                <ul class="submenu">
                    <li><a href="../../php/paginas/alta_pregunta.php">Alta pregunta</a></li>
                    <li><a href="../../js/paginas/alta_masiva_preguntas.html">Alta masiva</a></li>
                </ul>
            </li>
            <li class="categoria">
                <a href="../../js/paginas/listado_examenes.html">Exámenes</a>
                <ul class="submenu">
                    <li><a href="alta_examen.html">Alta examen</a></li>
                    <li><a href="#">Histórico</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- NAV PARA USUARIO -->
    <nav>
        <ul>
            <li class="categoria">
                <a href="../../js/paginas/historico.html">Histórico</a>
            </li>
            <li class="categoria">
                <a href="#">Examen predefinido</a>
            </li>
            <li class="categoria">
                <a href="#">Examen aleatorio</a>
            </li>
        </ul>
    </nav>
    <h3>Alta usuario</h3>
    <form method="post" class="formAltaUsuario" enctype="multipart/form-data">
        <label class="imagenAlta" id="imagenPre" value="<?php if(isset($_SESSION['editarUsuario'])){echo $usuario->getImagen();} ?>">
                <input type="file" accept="image/png, image/gif, image/jpeg" name="fichero" id="subir"/>
        </label>
        EMAIL:<br>
        <input type="mail" name="email" id="email" class="errorInputemail" value="<?php if(isset($_SESSION['editarUsuario'])){echo $_SESSION['editarUsuario'];}else{echo isset($_POST['email']) ? $_POST['email'] : '';} ?>" <?php if(isset($_SESSION['editarUsuario'])){echo "readonly";}?>>
        <br>
        NOMBRE:<br>
        <input type="text" name="nombre" id="nombre" class="errorInputnombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : '' ?>" placeholder="<?php if(isset($_SESSION['editarUsuario'])){echo $usuario->getNombre();} ?>">
        <br>
        APELLIDOS:<br>
        <input type="text" name="apellidos" id="apellidos" class="errorInputapellidos" value="<?php echo isset($_POST['apellidos']) ? $_POST['apellidos'] : '' ?>" placeholder="<?php if(isset($_SESSION['editarUsuario'])){echo $usuario->getApellidos();} ?>">
        <br>
        FECHA DE NACIMIENTO:<br>
        <input type="date" name="fechaNac" id="fechaNac" class="errorInputfechaNac" value="<?php if(isset($_SESSION['editarUsuario'])){echo $usuario->getFecha_nac();}else{echo isset($_POST['fechaNac']) ? $_POST['fechaNac'] : '';} ?>">
        <br>
        ROL:<br>
        <select name="rol">
            <option value="alumno" <?php if(isset($_SESSION['editarUsuario']) && $usuario->getRol()=="alumno"){echo "selected";}?>>alumno</option>
            <option value="administrador" <?php if(isset($_SESSION['editarUsuario']) && $usuario->getRol()=="administrador"){echo "selected";}?>>administrador</option>
        </select>
        <br><br>
        <input type="submit" name="btnGuardar" value="Guardar" class="botones">
    </form>
    <?php
    if(isset($_SESSION['usuario']))
    {
        
        if($usuario->getRol()=="alumno" && !isset($_SESSION['editarUsuario']))
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
                
                if(isset($_SESSION['editarUsuario']))
                {
                    $res = validator::validaAltaUsuario($usuario,false);
                }
                else{
                    $res = validator::validaAltaUsuario($usuario,true);
                }
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
                    if(isset($_SESSION['editarUsuario']))
                    {
                        BD::actualizaUsuario($usuario);
                        unset($_SESSION['editarUsuario']);
                        header('Location: alta_usuario.php');
                    }
                    else{
                        Sesion::inserta("usuarioCorreo",$usuario);
                        $id = (rand(0,5000) + time());
                        $mensaje = "Bienvenido a Autoescuela Alc&aacute;zar <br>Haz click en el siguiente enlace pra cambiar tu contrase&ntilde;a y as&iacute; confirmar tu registro<br><br><a href=\"http://localhost/autoescuela/php/paginas/cambiaPassword.php?id=${id}\">Aqu&iacute;</a>";
                        Sesion::inserta("mensaje",$mensaje);
                        Sesion::inserta("id",$id);
                        unset($_SESSION['editarUsuario']);
                        header('Location: enviaCorreo.php');
                    }
                    
                }
                
            }
        }
    }
    else{
        unset($_SESSION['editarUsuario']);
        header('Location: login.php');
    }
    

    ?>
</body>
</html>
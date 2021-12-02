<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambia contraseña</title>
    <?php
    require "../cargadores/cargarEntidades.php";
    require "../cargadores/cargarBD.php";
    require "../cargadores/cargarHelper.php";
    require "../cargadores/cargarSesion.php";
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
</head>
<body>
    <div class="cajaLogin">
        <form method="post" class="formLogin">
            Contraseña:<input id="correo" type="password" class="errorInput correo" name="password1">
            <br><br>
            Repita la contraseña: <input type="password" class="errorInput" name="password2">
            <br><br>
            <input type="submit" name="guardar" value="Guardar" class="boton">
            <aside><span></span></aside>
        </form>
    </div>
    <?php
        $id = $_GET['id'];
        $c = false;
        if(isset($_GET['c']))
        {
            $c = $_GET['c'];
        }
        BD::Conectar();
        $fecha = BD::selectFechaExpiracion($id);
        $fecha = strtotime($fecha);
        $actual = new DateTime();
        $actual = $actual->format('Y-m-d H:i:s');
        $actual = strtotime($actual);

        $usuario_pendiente = BD::selectPendientes($id);//devuelve el id_usuario donde id_md5 es id
        $usuario_usuario = BD::selectUsuarioId($usuario_pendiente);//devuelve el usuario correspondiente a ese id_md5
        if($usuario_pendiente==false)
        {
            //NO EXISTE EN PENDIENTES
            Sesion::abreSesion();
            Sesion::inserta("errorId","Este usuario no existe o no tiene ningún cambio de contraseña pendiente");
            header('Location: errorCambioPassword.php');
        }
        else{
            if($actual<$fecha)
            {
                if(isset($_POST['guardar']))
                {
                    if($usuario_usuario!=false && $usuario_pendiente!=false)
                    {
                        if($_POST['password1'] === $_POST['password2'])
                        {
                            $validar = validator::valida2Password($_POST['password1'], $_POST['password2']);
                            if($validar!=false)
                            {
                                echo $validar['password'];
                                echo "<style>.errorInput{border-color: red;}</style>";
                            }
                            else{
                                //TODO CORRECTO Y SE CAMBIA LA CONTRASEÑA
                                BD::actualizaUsuarioPassword($usuario_usuario->getId(), $_POST['password1']);
                                BD::borrarPendientesId($id);
                                setcookie("correo",$usuario_usuario->getCorreo(),time()+3600);
                                setcookie("password",$_POST['password1'],time()+3600);
                                header('Location: login.php');
                            }
                        }
                        else{
                            //echo "Las contraseñas no coinciden"; //poner bien
                            echo "<style>.errorInput{border-color: red;}</style>";
                            echo "<style>input + aside  > span:after{
                                color: red;
                                content: 'Las contraseñas no coinciden';
                                font-size: 50%;
                                background-color: #d1d1d1;
                                float:none;
                                margin:auto;}
                                
                                aside{margin-top:50px}</style>";
                        }
                    }
    
                }
            }
            else{
                if($usuario_usuario!=false)
                {
                    //EL TIEMPO DE EXPIRACION YA PASÓ
    
                    BD::borrarPendientesId($id);
                    if($c!=1)
                    {   
                        BD::borrarUsuarioId($usuario_usuario);
                    }
                    Sesion::abreSesion();
                    Sesion::inserta("errorTiempo","El tiempo para confirmar el cambio de contraseña ha expirado");
                    header('Location: errorCambioPassword.php');
                }
                
            }
        }
        
        
    ?>
</body>
</html>


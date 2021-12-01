<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require "../cargadores/cargarEntidades.php";
    require "../cargadores/cargarBD.php";
    require "../cargadores/cargarSesion.php";
    require "../cargadores/cargarHelper.php";
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
</head>
<body>
    <div class="cajaLogin">
    <img src="../../archivos/imagenesWeb/imagenCorta.png" alt="Logo autoescuela" class="fotoAutoescuela">
    <form method="post" class="formLogin">
        <label for="correo">Correo:</label><input id="correo" type="email" class="errorInput correo" name="txtcorreo" value="<?php if(isset($_COOKIE['correo']) && $_COOKIE['password']) echo $_COOKIE['correo']?>">
        <br><br>
        <label for="contra">Contraseña:</label><input id="contra" type="password" class="errorInput" name="txtPassword" value="<?php if(isset($_COOKIE['correo']) && $_COOKIE['password']) echo $_COOKIE['password']?>">
        <br><br>
        <label for="recu" class="recuerdame">Recuérdame:</label><input id="recu" type="checkbox" name="recuerdame" class="recuerdame"><aside><span><a href="olvidaPassword.php">He olvidado mi contraseña</a><br></span></aside>
        <br><br>
        <input type="submit" name="btnEnviar" value="Iniciar Sesion" class="boton">
    </form>
    </div>
    <?php
    if(isset($_POST['btnEnviar']))
    {
        BD::Conectar();
        $correo = $_POST['txtcorreo'];
        $contra = $_POST['txtPassword'];
        $usuario = new usuario("", $correo, "", "", $contra, "","","","");
        $log = validator::validaLogin($usuario);
        if($log===true)
        {
            Sesion::abreSesion();
            Sesion::inserta("usuario",$usuario);
            if(isset($_POST['recuerdame']))
            {
                setcookie("correo",$correo,time()+3600);
                setcookie("password",$contra,time()+3600);
            }
            else{
                setcookie("correo",$correo,time()-3600);
                setcookie("password",$contra,time()-3600);
            }
            
            header("Location: ../../js/paginas/alta_examen.html");
        }
        else{
            echo "<style>.errorInput{border-color: red;}</style>";
            echo "<style>#contra + aside  > span:after{
                color: red;
                content: '${log}';
                font-size: 50%;
                background-color: #d1d1d1;
                float:none;
                margin:auto;
            }
            
            aside{text-align: center;}</style>";
        }
    }
    ?>
</body>
</html>
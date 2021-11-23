<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require_once("../entidades/usuario.php");
    require_once("../bd/bd.php");
    require_once("../sesion/sesion.php");
    include("../helper/validator.php");
    ?>
    <style><?php include('../../css/main.css'); ?></style>
</head>
<body>

    <div class="cajaLogin">
    <form method="post">
        Correo: <input type="email" class="errorInput correo" name="txtcorreo" value="<?php if(isset($_COOKIE['correo']) && $_COOKIE['password']) echo $_COOKIE['correo']?>">
        <br><br>
        Contraseña: <input type="password" class="errorInput" name="txtPassword" value="<?php if(isset($_COOKIE['correo']) && $_COOKIE['password']) echo $_COOKIE['password']?>">
        <br><br>
        Recuérdame<input type="checkbox" name="recuerdame" class="recuerdame">
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
            
            header("Location: pruebas.php");
        }
        else{
            echo "<span class='errorLogin'>${log}</span>";
            echo "<style>.errorInput{border-color: red;}</style>";
        }
    }
    ?>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Correo</title>
    <?php
    require "../cargadores/cargarHelper.php";
    require "../cargadores/cargarEntidades.php";
    require "../cargadores/cargarBD.php";
    require "../cargadores/cargarSesion.php";
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
</head>
<body>
<div class="cajaLogin">
    <form method="post" class="formLogin">
        <label for="correo">Correo:</label><input id="correo" type="email" class="errorInput correo" name="txtcorreo">
        <br><br>
        <input type="submit" name="btnEnviar" value="Enviar correo" class="boton">
        <aside><span></span></aside>
    </form>
    <p>Se enviará un correo con un enlace para restablecer tu contraseña <br>Dispones de 10 días para cambiarla</p>
    </div>
    <?php
    if(isset($_POST['btnEnviar']))
    {
        BD::Conectar();
        $id_usuario = BD::selectUsuarioEmail($_POST['txtcorreo']);
        if($id_usuario!=false)
        {
            $id = (rand(0,5000) + time());
            $mensaje = "Bienvenido a Autoescuela Alc&aacute;zar <br>Haz click en el siguiente enlace pra cambiar tu contrase&ntilde;a<br><br><a href=\"http://localhost/autoescuela/php/paginas/cambiaPassword.php?c=1&id=${id}\">Aqu&iacute;</a>";
            Sesion::abreSesion();
            $usuario = new usuario("", $_POST['txtcorreo'], "", "", "", "", "", "");
            Sesion::inserta("usuario",$usuario);
            Sesion::inserta("mensaje",$mensaje);
            Sesion::inserta("id",$id);
            header('Location: enviaCorreo.php');
            
        }
        else{
            echo "<style>.errorInput{border-color: red;}</style>";
            echo "<style>input + aside  > span:after{
                color: red;
                content: 'Este correo no está asociado a ninguna cuenta';
                font-size: 50%;
                background-color: #d1d1d1;
                float:none;
                margin:auto;}
                
                aside{margin-top:50px}</style>";
            
        }
    }
        
    ?>
</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
        require "../cargadores/cargarEntidades.php";
        require "../cargadores/cargarHelper.php";
        require "../cargadores/cargarSesion.php";
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
</head>
<body>
    <form method="post" class="formAltaUsuario">
        EMAIL:<br>
        <input type="mail" name="email" id="email" class="errorInputemail">
        <br>
        NOMBRE:<br>
        <input type="text" name="nombre" id="nombre" class="errorInputnombre">
        <br>
        APELLIDOS:<br>
        <input type="text" name="apellidos" id="apellidos" class="errorInputapellidos">
        <br>
        FECHA DE NACIMIENTO:<br>
        <input type="date" name="fechaNac" id="fechaNac" class="errorInputfechaNac">
        <br>
        ROL:<br>
        <select name="rol">
            <option value="usuario" selected>usuario</option>
            <option value="administrador">administrador</option>
        </select>
        <br><br>
        <input type="submit" name="btnGuardar" value="Guardar">
    </form>
    <?php
    
    if(isset($_POST['btnGuardar']))
    {
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
            Sesion::abreSesion();
            Sesion::inserta("usuario",$usuario);
            header('Location: enviaCorreo.php');
        }
    }

    ?>
</body>
</html>
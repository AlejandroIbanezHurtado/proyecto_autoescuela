<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style><?php include('../../css/main.css'); ?></style>
    <?php include('../entidades/usuario.php'); ?>
    <?php include('../helper/validator.php'); ?>
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
        CONTRASEÑA:<br>
        <input type="text" name="password1" id="password1" class="errorInputcontraseña1">
        <br>
        CONFIRMAR CONTRASEÑA:<br>
        <input type="text" name="password2" id="password2" class="errorInputcontraseña2">
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
        $password="";
        
        if($_POST['password1'] === $_POST['password2'])
        {
            $password = $_POST['password1'];
        }
        else{
            echo "<style>.errorInputcontraseña1{border-color: red;}</style>";
            echo "<style>.errorInputcontraseña2{border-color: red;}</style>";
        }
        
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
            header('Location: login.php');
        }
    }

    ?>
</body>
</html>
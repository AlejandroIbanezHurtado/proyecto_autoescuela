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
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
</head>
<body>
    <div class="cajaLogin">
        <form method="post" class="formLogin">
            Contraseña:<input id="correo" type="email" class="errorInput correo" name="txtcorreo">
            <br><br>
            Repita la contraseña: <input type="password" class="errorInput" name="txtPassword">
            <br><br>
            <input type="submit" name="guardar" value="Guardar" class="boton">
        </form>
    </div>
    <?php
        var_dump($_GET);
        if($_POST['guardar'])
        {
            //if()
        }
    ?>
</body>
</html>


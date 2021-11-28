<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    require "../cargadores/cargarSesion.php";
    ?>
    <link href="../../css/main.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="../../archivos/imagenesWeb/logoAutoescuela.jpg">
</head>
<body>
    <img src="../../archivos/imagenesWeb/warning.png" alt="Imagen Warning" class="caution">
    <p class="errorCambioPassword">
        <?php
        Sesion::abreSesion();
        //var_dump($_SESSION);
        if(isset($_SESSION['errorId']))
        {
            echo $_SESSION['errorId'];
            unset($_SESSION['errorId']);
        }
        else{
            if(isset($_SESSION['errorTiempo'])){
                echo $_SESSION['errorTiempo'];
                unset($_SESSION['errorTiempo']);
            }
            else
            {
                echo "Página no disponible";
            }
        }
        ?>
    </p>
    <section><a href="login.php">Inciar sesión</a></section>
</body>
</html>

<?php
require "../cargadores/cargarSesion.php";
require "../helper/correo.php";
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
$usuario = Sesion::miraSiExiste("usuario");
//generar id
$id = (rand(0,5000) + time());
if($usuario!="" && $usuario!=null)
{
    $email = $usuario->getCorreo();

    $mensaje = "Bienvenido a Autoescuela Alc&aacute;zar <br>Haz click en el siguiente enlace pra cambiar tu contrase&ntilde;a y as&iacute; confirmar tu registro<br><br><a href=\"http://localhost/autoescuela/php/paginas/cambiaPassword.php?id=${id}\">Aqu&iacute;</a>";
    correo::enviaCorreo("Confirmacion de registro",$mensaje,$email);

    $fecha_expiracion = new DateTime();

    // $fecha_expiracion->add(new DateInterval('P30D'));
    $fecha_expiracion->add(new DateInterval('PT5M'));
    $fecha_expiracion = date_format($fecha_expiracion, 'Y-m-d H:i:s');

    //insertamos usuario en usuarios
    BD::Conectar();
    BD::insertarUsuario($usuario);

    //leemos su id
    $id_usuario = BD::selectUsuarioEmail($email);
    BD::insertarPendientes($id, $id_usuario,$fecha_expiracion);
}

//Redirigimos a otra página
//header("Location: ../../js/paginas/alta_examen.html");
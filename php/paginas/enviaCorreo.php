<?php
header("Location: ../../js/paginas/alta_examen.html");
require "../cargadores/cargarSesion.php";
require "../helper/correo.php";
require "../cargadores/cargarBD.php";
require "../cargadores/cargarEntidades.php";
Sesion::abreSesion();
$usuario = Sesion::miraSiExiste("usuarioCorreo");
$mensaje = Sesion::miraSiExiste("mensaje");
unset($_SESSION['usuarioCorreo']);
unset($_SESSION['mensaje']);
$id = Sesion::miraSiExiste("id");
if($usuario!="" && $usuario!=null)
{
    $email = $usuario->getCorreo();

    correo::enviaCorreo("Confirmacion de registro",$mensaje,$email);

    $fecha_expiracion = new DateTime();

    // $fecha_expiracion->add(new DateInterval('P10D'));
    $fecha_expiracion->add(new DateInterval('PT1M'));
    $fecha_expiracion = date_format($fecha_expiracion, 'Y-m-d H:i:s');

    //insertamos usuario en usuarios
    BD::Conectar();
    var_dump($usuario);
    BD::insertarUsuario($usuario);

    //leemos su id
    $id_usuario = BD::selectUsuarioEmail($email);
    BD::insertarPendientes($id, $id_usuario,$fecha_expiracion);
}

//Redirigimos a otra página
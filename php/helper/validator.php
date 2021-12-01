<?php
require_once "../cargadores/cargarBD.php";
class validator {
    public static function validaLogin(usuario $usuario)
    {
        $res = true;
        BD::Conectar();
        
        if(count(BD::selectLoginUsuario($usuario))==0)
        {
            $res = "Correo y/o contraseña inválidos";
        }
        return $res;
    }

    public static function validaAltaUsuario(usuario $usuario)
    {
        BD::Conectar();
        $res = [];
        if(filter_var($usuario->getCorreo(), FILTER_VALIDATE_EMAIL)==false || BD::selectUsuarioEmail($usuario->getCorreo())!=false)
        {
            $res['email'] = "Correo no válido";
        }
        if(trim($usuario->getNombre())=="")
        {
            $res['nombre'] = "Nombre vacío";
        }
        if(trim($usuario->getApellidos())=="")
        {
            $res['apellidos'] = "Apellidos vacíos";
        }
        if(trim($usuario->getPassword())=="" || strlen($usuario->getPassword())<8)
        {
            $res['password'] = "Contraseña inválida";
        }
        if($usuario->getFecha_nac()!="")
        {
            $fecha=strtotime($usuario->getFecha_nac());
            $dia = date("d", $fecha);
            $mes = date("m", $fecha);
            $año = date("Y", $fecha);
            if(!checkdate($mes, $dia, $año))
            {
                $res['fechaNac'] = "Fecha inválida";
            }
        }
        else{
            $res['fechaNac'] = "Fecha inválida";
        }
        return $res;
    }

    public static function valida2Password($password1, $password2)
    {
        $res = false;
        if($password1 === $password2)
        {
            if(trim($password1)=="" || strlen($password1)<8)
            {
                $res['password'] = "Contraseña inválida";
            }
        }
        
        return $res;
    }

    public static function validaAltaPregunta(pregunta $pregunta)
    {
        BD::Conectar();
        $enunciado = BD::selectPreguntaEnunciado($pregunta->getEnunciado());
        $res = [];
        if(trim($pregunta->getEnunciado())=="" || !empty($enunciado))
        {
            $res['enunciado'] = "Enunciado no disponible";
        }
        if(trim($pregunta->getVectorRespuestas()[0])=="")
        {
            $res['respuesta1'] = "Respuesta 1 vacía";
        }
        if(trim($pregunta->getVectorRespuestas()[1])=="")
        {
            $res['respuesta2'] = "Respuesta 2 vacía";
        }
        if(trim($pregunta->getVectorRespuestas()[2])=="")
        {
            $res['respuesta3'] = "Respuesta 3 vacía";
        }
        if(trim($pregunta->getVectorRespuestas()[3])=="")
        {
            $res['respuesta4'] = "Respuesta 4 vacía";
        }
        return $res;
    }

    public static function validaTematica(tematica $tematica)
    {
        BD::Conectar();
        $res = [];
        $tema = BD::selectTematicaTema($tematica->getTema());
        if(trim($tematica->getTema())=="" || !empty($tema))
        {
            $res['tema'] = "Temática no disponible";
        }
        return $res;
    }
}
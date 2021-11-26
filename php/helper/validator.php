<?php
class validator {
    public static function validaLogin(usuario $usuario)
    {
        $res = true;
        BD::Conectar();
        
        if(count(BD::selectLoginUsuario($usuario))==0)
        {
            $res = "Correo o contraseña inválidos";
        }
        return $res;
    }

    public static function validaAltaUsuario(usuario $usuario)
    {
        $res = [];
        if(filter_var($usuario->getCorreo(), FILTER_VALIDATE_EMAIL)==false)
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
}
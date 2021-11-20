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
}
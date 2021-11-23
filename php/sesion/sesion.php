<?php
class Sesion{
    public static function abreSesion()
    {
        session_start();
    }

    public static function inserta($indice, $valor)
    {
        $_SESSION[$indice] = $valor;
    }

    public static function miraSiExiste($indice)
    {
        return $_SESSION[$indice]?$_SESSION[$indice]:"";
    }

    public static function terminaSesion()
    {
        session_destroy();
    }
}
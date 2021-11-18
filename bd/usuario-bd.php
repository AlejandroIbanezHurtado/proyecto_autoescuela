<?php
require_once("entidades/usuario.php");
class usuario_bd
{
    private static $con;

    public static function Conectar()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root','');
    }

    public static function selectUsuario():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM usuarios");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $usuario = new usuario($registro->id, $registro->correo, $registro->nombre, $registro->apellidos, $registro->password, $registro->fecha_nac, $registro->rol, $registro->imagen, $registro->activo);
            $vector [$registro->id] = $usuario;
        }

        return $vector;
    }

    public static function borrarUsuarioId($valor)
    {
        $string = "DELETE FROM usuarios WHERE id = '${valor}';";
        $registros = self::$con->exec($string);
    }

    public static function insertarUsuario($correo, $nombre, $apellidos, $password, $fecha_nac, $rol, $imagen, $activo)
    {
        $string = "INSERT INTO usuarios (id, correo, nombre, apellidos, password, fecha_nac, rol, imagen, activo)  VALUES (NULL, '${correo}','${nombre}','${apellidos}','${password}','${fecha_nac}','${rol}','${imagen}','${activo}');";
        $registros = self::$con->exec($string);
    }

    /*public static function actualizaImagen($tabla, $id, $imagen)
    {
        $string = "UPDATE ".$tabla." SET imagen = '".$imagen."' WHERE nombre = '".$nombre."';";
        return $registros = self::$con->exec($string);
    }*/
}

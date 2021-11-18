<?php
require_once("entidades/usuario.php");
class pregunta_bd
{
    private static $con;

    public static function Conectar()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root','');
    }

    public static function selectPregunta():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM preguntas");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $usuario = new usuario($registro->id, $registro->enunciado, $registro->id_respuesta_correcta, $registro->recurso, $registro->id_tematica);
            $vector [$registro->id] = $usuario;
        }

        return $vector;
    }

    public static function borrarPreguntaId($valor)
    {
        $string = "DELETE FROM usuarios WHERE id = '${valor}';";
        $registros = self::$con->exec($string);
    }

    public static function insertarPregunta($correo, $nombre, $apellidos, $password, $fecha_nac, $rol, $imagen, $activo)
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

<?php
require_once("respuesta/usuario.php");
class respuesta_bd
{
    private static $con;

    public static function Conectar()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root','');
    }

    public static function selectRespuesta():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM respuestas");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $respuesta = new respuesta($registro->id, $registro->enunciado, $registro->id_pregunta);
            $vector [$registro->id] = $respuesta;
        }

        return $vector;
    }

    public static function borrarRespuestaId($valor)
    {
        $string = "DELETE FROM respuestas WHERE id = '${valor}';";
        $registros = self::$con->exec($string);
    }

    public static function insertarRespuesta($enunciado, $id_pregunta)
    {
        $string = "INSERT INTO respuestas (id, enuncaido, id_pregunta)  VALUES (NULL, '${enunciado}','${id_pregunta}');";
        $registros = self::$con->exec($string);
    }
}

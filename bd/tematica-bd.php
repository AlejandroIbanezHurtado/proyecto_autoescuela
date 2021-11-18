<?php
require_once("entidades/tematica.php");
class tematica_bd
{
    private static $con;

    public static function Conectar()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root','');
    }

    public static function selectTematica():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM tematica");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $tematica = new tematica($registro->id, $registro->tema);
            $vector [$registro->id] = $tematica;
        }

        return $vector;
    }

    public static function borrarTematicaId($valor)
    {
        $string = "DELETE FROM tematica WHERE id = '${valor}';";
        $registros = self::$con->exec($string);
    }

    public static function insertarTematica($tema)
    {
        $string = "INSERT INTO tematica (id, tema)  VALUES (NULL, '${tema}');";
        $registros = self::$con->exec($string);
    }
}

<?php
require_once("entidades/usuario.php");
require_once("entidades/pregunta.php");
require_once("entidades/tematica.php");
require_once("entidades/respuesta.php");
require_once("entidades/examen.php");
require_once("entidades/examen-pregunta.php");
require_once("entidades/examen-usuario.php");
class BD
{
    private static $con;

    public static function Conectar()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root','');
    }

    //USUARIO
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
        return self::$con->errorInfo();
    }

    public static function insertarUsuario($correo, $nombre, $apellidos, $password, $fecha_nac, $rol, $imagen, $activo)
    {
        $string = "INSERT INTO usuarios (id, correo, nombre, apellidos, password, fecha_nac, rol, imagen, activo)  VALUES (NULL, '${correo}','${nombre}','${apellidos}','${password}','${fecha_nac}','${rol}','${imagen}','${activo}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    /*public static function actualizaImagen($tabla, $id, $imagen)
    {
        $string = "UPDATE ".$tabla." SET imagen = '".$imagen."' WHERE nombre = '".$nombre."';";
        return $registros = self::$con->exec($string);
    }*/



    //TEMATICA
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
        return self::$con->errorInfo();
    }

    public static function insertarTematica($tema)
    {
        $string = "INSERT INTO tematica (id, tema)  VALUES (NULL, '${tema}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    
    //RESPUESTA
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
        return self::$con->errorInfo();
    }

    public static function insertarRespuesta($enunciado, $id_pregunta)
    {
        $string = "INSERT INTO respuestas (id, enunciado, id_pregunta)  VALUES (NULL, '${enunciado}','${id_pregunta}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }


    //PREGUNTA
    public static function selectPregunta():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM preguntas");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $pregunta = new pregunta($registro->id, $registro->enunciado, $registro->id_respuesta_correcta, $registro->recurso, $registro->id_tematica);
            $vector [$registro->id] = $pregunta;
        }

        return $vector;
    }

    public static function borrarPreguntaId($valor)
    {
        $string = "DELETE FROM preguntas WHERE id = '${valor}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarPregunta($enunciado, $id_respuesta_correcta, $recurso, $id_tematica)
    {
        if($recurso==NULL)
        {
            $string = "INSERT INTO preguntas (id, enunciado, id_respuesta_correcta, recurso, id_tematica)  VALUES (NULL, '${enunciado}','${id_respuesta_correcta}',NULL,'${id_tematica}');";
        }
        
        if($id_respuesta_correcta==NULL)
        {
            $string = "INSERT INTO preguntas (id, enunciado, id_respuesta_correcta, recurso, id_tematica)  VALUES (NULL, '${enunciado}',NULL,'${recurso}','${id_tematica}');";
        }
        if($recurso==NULL && $id_respuesta_correcta==NULL)
        {
            $string = "INSERT INTO preguntas (id, enunciado, id_respuesta_correcta, recurso, id_tematica)  VALUES (NULL, '${enunciado}',NULL,NULL,'${id_tematica}');";
        }

        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function actualizaRespuestaCorrecta($valor, $id)
    {
        $string = "UPDATE preguntas SET id_respuesta_correcta = '${valor}' WHERE id = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }


    //EXAMEN
    public static function selectExamen():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM examen");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $examen = new examen($registro->id, $registro->descripcion, $registro->duracion, $registro->num_preguntas, $registro->activo);
            $vector [$registro->id] = $examen;
        }

        return $vector;
    }

    public static function borrarExamenId($valor)
    {
        $string = "DELETE FROM examen WHERE id = '${valor}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarExamen($descripcion, $duracion, $num_preguntas, $activo)
    {
        $string = "INSERT INTO examen (id, descripcion, duracion, num_preguntas, activo)  VALUES (NULL, '${descripcion}','${duracion}','${num_preguntas}','${activo}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }


    //EXAMEN-PREGUNTA
    public static function selectExamenPregunta():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM examen_pregunta");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $examen_pregunta = new examen_pregunta($registro->id_examen, $registro->id_pregunta);
            $vector [$registro->id_examen] = $examen_pregunta;
        }

        return $vector;
    }

    public static function borrarExamenPreguntaId_Pregunta($valor)
    {
        $string = "DELETE FROM examen_pregunta WHERE id_pregunta = '${valor}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function borrarExamenPreguntaId_Examen($valor)
    {
        $string = "DELETE FROM examen_pregunta WHERE id_examen = '${valor}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarExamenPregunta($id_examen, $id_pregunta)
    {
        $string = "INSERT INTO examen_pregunta (id_examen, id_pregunta)  VALUES ('${id_examen}','${id_pregunta}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }


    //EXAMEN-USUARIO
    public static function selectExamenUsuario():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM examen_usuario");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $examen_usuario = new examen_usuario($registro->id, $registro->id_examen, $registro->id_usuario, $registro->fecha, $registro->calificacion, $registro->ejecucion);
            $vector [$registro->id] = $examen_usuario;
        }

        return $vector;
    }

    public static function borrarExamenUsuarioId($valor)
    {
        $string = "DELETE FROM examen_usuario WHERE id = '${valor}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarExamenUsuario($id_examen, $id_usuario, $calificacion, $ejecucion)
    {
        $string = "INSERT INTO examen_usuario (id, id_examen, id_usuario, fecha, calificacion, ejecucion)  VALUES (NULL, '${id_examen}','${id_usuario}', NOW(),'${calificacion}','${ejecucion}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }
}
<?php
require "../cargadores/cargarEntidades.php";
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

    public static function borrarUsuarioId($usuario)
    {
        $id = $usuario->getId();
        $string = "DELETE FROM usuarios WHERE id = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarUsuario($usuario)
    {
        $correo = $usuario->getCorreo();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $password = $usuario->getPassword();
        $fecha_nac = $usuario->getFecha_nac();
        $rol = $usuario->getRol();
        $imagen = $usuario->getImagen();

        if($imagen==NULL)
        {
            $string = "INSERT INTO usuarios (id, correo, nombre, apellidos, password, fecha_nac, rol, imagen)  VALUES (NULL, '${correo}','${nombre}','${apellidos}','${password}','${fecha_nac}','${rol}',NULL);";
        }
        else{
            $string = "INSERT INTO usuarios (id, correo, nombre, apellidos, password, fecha_nac, rol, imagen)  VALUES (NULL, '${correo}','${nombre}','${apellidos}','${password}','${fecha_nac}','${rol}','${imagen}');";
        }
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function selectLoginUsuario(usuario $usuario)
    {
        $correo = $usuario->getCorreo();
        $password = $usuario->getPassword();
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM usuarios WHERE CORREO = '${correo}' AND PASSWORD = '${password}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $usuario = new usuario($registro->id, $registro->correo, $registro->nombre, $registro->apellidos, $registro->password, $registro->fecha_nac, $registro->rol, $registro->imagen);
            $vector [$registro->id] = $usuario;
        }

        return $vector;
    }

    public static function selectUsuarioEmail($email)
    {
        $res = false;
        $resultado = self::$con->query("SELECT * FROM usuarios WHERE correo = '${email}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $res = $registro->id;
        }

        return $res;
    }

    public static function selectUsuarioId($id)
    {
        $res=false;
        $resultado = self::$con->query("SELECT * FROM usuarios WHERE id = '${id}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $usuario = new usuario($registro->id, $registro->correo, $registro->nombre, $registro->apellidos, $registro->password, $registro->fecha_nac, $registro->rol, $registro->imagen);
            $res = $usuario;
        }

        return $res;
    }

    public static function actualizaUsuarioPassword($id, $password)
    {
        $string = "UPDATE usuarios SET password = '${password}' WHERE id = '${id}'";
        return $registros = self::$con->exec($string);
    }


    /*public static function actualizaImagen($tabla, $id, $imagen)
    {
        //$string = "UPDATE ".$tabla." SET imagen = '".$imagen."' WHERE nombre = '".$nombre."';";
        $string = "UPDATE ${tabla} SET IMAGEN = '${imagen}' WHERE nombre = '${nombre}'";
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

    public static function borrarTematicaId($tematica)
    {
        $id = $tematica->getId();
        $string = "DELETE FROM tematica WHERE id = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarTematica($tematica)
    {
        $tema = $tematica->getTema();
        $string = "INSERT INTO tematica (id, tema)  VALUES (NULL, '${tema}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    
    //RESPUESTA
    public static function selectRespuesta():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT respuestas.id as \"id_respuesta\", respuestas.enunciado as \"enunciado_respuesta\", preguntas.id as \"id_pregunta\", preguntas.enunciado as \"enunciado_pregunta\", preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM respuestas INNER JOIN preguntas on respuestas.id_pregunta = preguntas.id");
        $rep = "";
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $idPreg = $registro->id_pregunta;
            
            if($idPreg!=$rep)
            {
                $resultado2 = self::$con->query("SELECT id FROM respuestas WHERE id_pregunta ='${idPreg}'");
                $vectorResp = array();
                while ($registro2 = $resultado2->fetch(PDO::FETCH_OBJ))
                {
                    $vectorResp[] = $registro2->id;
                }
                $rep = $idPreg;

                
            }
            $enunPreg = utf8_encode($registro->enunciado_pregunta);
            $enunResp = utf8_encode($registro->enunciado_respuesta);
            
            $id_pregunta = new pregunta($registro->id_pregunta, $enunPreg, $registro->id_respuesta_correcta, $registro->recurso, $registro->id_tematica, $vectorResp);
            $respuesta = new respuesta($registro->id_respuesta, $enunResp, $id_pregunta);
            $vector [$registro->id_respuesta] = $respuesta;
            
        }

        return $vector;
    }

    public static function borrarRespuestaId($respuesta)
    {
        $id = $respuesta->getId();
        $string = "DELETE FROM respuestas WHERE id = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarRespuesta($respuesta)
    {
        $enunciado = $respuesta->getEnunciado();
        $id_pregunta = $respuesta->getId_pregunta();
        $id_pregunta = $id_pregunta->getId();
        $string = "INSERT INTO respuestas (id, enunciado, id_pregunta)  VALUES (NULL, '${enunciado}','${id_pregunta}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }


    //PREGUNTA
    public static function selectPregunta():array
    {
        $vector = [];
        $resultado = self::$con->query("SELECT respuestas.id as id_respuesta, respuestas.enunciado as enunciado_respuesta, tematica.id as id_tematica, tematica.tema, preguntas.id as id_pregunta, preguntas.enunciado as enunciado_pregunta, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM respuestas INNER JOIN preguntas on respuestas.id_pregunta = preguntas.id inner join tematica on tematica.id = preguntas.id_tematica");
        $rep = "";
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $idPreg = $registro->id_pregunta;
            
            if($idPreg!=$rep)
            {
                $resultado2 = self::$con->query("SELECT id FROM respuestas WHERE id_pregunta ='${idPreg}'");
                $vectorResp = [];
                while ($registro2 = $resultado2->fetch(PDO::FETCH_OBJ))
                {
                    $vectorResp[] = $registro2->id;
                }
                $rep = $idPreg;
                $enunPreg = utf8_encode($registro->enunciado_pregunta);
                $enunResp = utf8_encode($registro->enunciado_respuesta);

                $tematica = new tematica($registro->id_tematica, $registro->tema);
                $respuesta = new respuesta($registro->id_respuesta, $enunResp, $registro->id_pregunta);
                $id_pregunta = new pregunta($registro->id_pregunta, $enunPreg, $respuesta, $registro->recurso, $tematica, $vectorResp);
                $vector [$registro->id_respuesta] = $id_pregunta;
            }
            
        }

        return $vector;
    }

    public static function borrarPreguntaId($pregunta)
    {
        $id = $pregunta->getId();
        $string = "DELETE FROM preguntas WHERE id = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarPregunta($pregunta)
    {
        $enunciado = $pregunta->getEnunciado();
        $id_respuesta_correcta = $pregunta->getId_respuesta_correcta();
        $recurso = $pregunta->getRecurso();
        $id_tematica = $pregunta->getId_tematica();

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

    public static function borrarExamenId($examen)
    {
        $id = $examen->getId();
        $string = "DELETE FROM examen WHERE id = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarExamen($examen)
    {
        $descripcion = $examen->getDescripcion();
        $duracion = $examen->getDuracion();
        $num_preguntas = $examen->getNum_preguntas();
        $activo = $examen->getActivo();
        $string = "INSERT INTO examen (id, descripcion, duracion, num_preguntas, activo)  VALUES (NULL, '${descripcion}','${duracion}','${num_preguntas}','${activo}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }


    //EXAMEN-PREGUNTA
    public static function selectExamenPregunta():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT examen.id as id_examen, examen.descripcion, examen.duracion, examen.num_preguntas, examen.activo, preguntas.id as id_pregunta, preguntas.enunciado, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica from examen_pregunta inner join examen on id_examen = examen.id inner join preguntas on id_pregunta = preguntas.id");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $idPreg = $registro->id_pregunta;
            $resultado2 = self::$con->query("SELECT id FROM respuestas WHERE id_pregunta ='${idPreg}'");
            $vectorResp = array();
            while ($registro2 = $resultado2->fetch(PDO::FETCH_OBJ))
            {
                $vectorResp[] = $registro2->id;
            }
            $examen = new examen($registro->id_examen, $registro->descripcion, $registro->duracion, $registro->num_preguntas, $registro->activo);
            $pregunta = new pregunta($registro->id_pregunta, $registro->enunciado, $registro->id_respuesta_correcta, $registro->recurso, $registro->id_tematica, $vectorResp);
            $examen_pregunta = new examen_pregunta($examen, $pregunta);
            $vector [$registro->id_examen] = $examen_pregunta;
        }

        return $vector;
    }

    public static function borrarExamenPreguntaId_Pregunta($examen_pregunta)
    {
        $id = $examen_pregunta->getId_pregunta();
        $id = $id->getId();
        $string = "DELETE FROM examen_pregunta WHERE id_pregunta = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function borrarExamenPreguntaId_Examen($examen_pregunta)
    {
        $id = $examen_pregunta->getId_examen();
        $id = $id->getId();
        $string = "DELETE FROM examen_pregunta WHERE id_examen = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarExamenPregunta($examen_pregunta)
    {
        $id_examen = $examen_pregunta->getId_Examen();
        $id_examen = $id_examen->getId();
        $id_pregunta = $examen_pregunta->getId_pregunta();
        $id_pregunta = $id_pregunta->getId();
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

    public static function borrarExamenUsuarioId($examen_usuario)
    {
        $id = $examen_usuario->getId();
        $string = "DELETE FROM examen_usuario WHERE id = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarExamenUsuario($examen_usuario)
    {
        $id_examen = $examen_usuario->getId_examen();
        $id_usuario = $examen_usuario->getId_usuario();
        $calificacion = $examen_usuario->getCalificacion();
        $ejecucion = $examen_usuario->getEjecucion();
        $string = "INSERT INTO examen_usuario (id, id_examen, id_usuario, fecha, calificacion, ejecucion)  VALUES (NULL, '${id_examen}','${id_usuario}', NOW(),'${calificacion}','${ejecucion}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    //PENDIENTES
    public static function selectPendientes($id)
    {
        $res = false;
        $resultado = self::$con->query("SELECT * FROM pendientes WHERE id_md5 = '${id}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $res = $registro->id_usuario;
        }

        return $res;
    }

    public static function selectPendientesEmail($email)
    {
        $res = false;
        $resultado = self::$con->query("SELECT * FROM pendientes WHERE id_usuario = '${email}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $res = $registro->id_md5;
        }

        return $res;
    }

    public static function selectPendientesIdUsuario($id_usuario)
    {
        $res = false;
        $resultado = self::$con->query("SELECT * FROM pendientes WHERE id_usuario = '${id_usuario}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $res = $registro->id_usuario;
        }

        return $res;
    }

    public static function selectFechaExpiracion($id)
    {
        $res = false;
        $resultado = self::$con->query("SELECT * FROM pendientes WHERE id_md5 = '${id}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $res = $registro->fecha_expiracion;
        }

        return $res;
    }

    public static function borrarPendientesId($id)
    {
        $string = "DELETE FROM pendientes WHERE id_md5 = '${id}';";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    public static function insertarPendientes($id, $id_usuario,$fecha_expiracion)
    {
        $string = "INSERT INTO pendientes (id_md5, id_usuario, fecha_expiracion) VALUES ('${id}','${id_usuario}','${fecha_expiracion}');";
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }

    
    
}
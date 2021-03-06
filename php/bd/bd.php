<?php
require "../cargadores/cargarEntidades.php";
class BD
{
    private static $con;
    // private static $transactionCount = 0;
    // private static $transactionCounter = 0;

    public static function Conectar()
    {
        self::$con = new PDO('mysql:host=localhost;dbname=autoescuela', 'root','');
    }

    public static function beginTransaction()
    {
        return self::$con->beginTransaction();
    }

    public static function commit()
    {
        return self::$con->commit();
    }

    public static function rollBack()
    {
        return self::$con->rollBack();
    }

    public static function lastError()
    {
        return self::$con->errorInfo();
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

    public static function selectUsuarioEmail2($email)
    {
        $res = false;
        $resultado = self::$con->query("SELECT * FROM usuarios WHERE correo = '${email}';");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $usuario = new usuario($registro->id, $registro->correo, $registro->nombre, $registro->apellidos, $registro->password, $registro->fecha_nac, $registro->rol, $registro->imagen);
            $res = $usuario;
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

    public static function obtenUsuariosPaginados(int $pagina, int $filas):array
    {
        $registros = array();
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $res = self::$con->query("select * from usuarios");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res= self::$con->query("select * from usuarios limit $inicio, $filas");
            while ($registro = $res->fetch(PDO::FETCH_OBJ)) {
                $usuario = new usuario($registro->id, $registro->correo, $registro->nombre, $registro->apellidos, $registro->password, $registro->fecha_nac, $registro->rol, $registro->imagen);
                $registros[] = $usuario;
            }
        }
        return $registros;
    }

    public static function actualizaUsuarioPassword($id, $password)
    {
        $string = "UPDATE usuarios SET password = '${password}' WHERE id = '${id}'";
        return $registros = self::$con->exec($string);
    }

    public static function actualizaUsuario($usuario)
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
            $string = "UPDATE usuarios set nombre = '${nombre}', apellidos='${apellidos}', fecha_nac='${fecha_nac}', rol = '${rol}', imagen = NULL WHERE correo = '${correo}'";
        }
        else{
            $string = "UPDATE usuarios set nombre = '${nombre}', apellidos='${apellidos}', fecha_nac='${fecha_nac}', rol = '${rol}', imagen = '${imagen}' WHERE correo = '${correo}'";
        }
        $registros = self::$con->exec($string);
        return self::$con->errorInfo();
    }


    //TEMATICA
    public static function selectTematica():array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM tematica");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $tema = utf8_encode($registro->tema);
            $tematica = new tematica($registro->id, $tema);
            $vector [$registro->id] = $tematica;
        }
        return $vector;
    }

    public static function obtenTematicasPaginados(int $pagina, int $filas):array
    {
        $registros = array();
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $res = self::$con->query("select * from tematica");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res = self::$con->query("select * from tematica limit $inicio, $filas");
            while ($registro = $res->fetch(PDO::FETCH_OBJ)) {
                $tematica = new tematica($registro->id, $registro->tema);
                $registros[] = $tematica;
            }
        }
        return $registros;
    }

    public static function selectTematicaTema($tema):array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM tematica where tema = '${tema}'");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $tema = utf8_encode($registro->tema);
            $tematica = new tematica($registro->id, $tema);
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

    public static function selectRespuestaEnunciadoPeq($enunciado, $pregunta)
    {
        $vector = false;
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $resultado = self::$con->query("SELECT id from respuestas where enunciado = '${enunciado}' AND id_pregunta = '${pregunta}'");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $vector = $registro->id;
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
                $enunTema = utf8_encode($registro->tema);

                $tematica = new tematica($registro->id_tematica, $enunTema);
                $respuesta = new respuesta($registro->id_respuesta_correcta, $enunResp, $registro->id_pregunta);
                $id_pregunta = new pregunta($registro->id_pregunta, $enunPreg, $respuesta, $registro->recurso, $tematica, $vectorResp);
                $vector [$registro->id_pregunta] = $id_pregunta;
            }
            
        }

        return $vector;
    }

    public static function obtenPreguntasPaginados(int $pagina, int $filas):array
    {
        $registros = array();
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $res = self::$con->query("select * from preguntas");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res = self::$con->query("SELECT DISTINCT preguntas.id as id_pregunta, tematica.id as id_tematica, tematica.tema, preguntas.enunciado as enunciado_pregunta, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM preguntas inner join tematica on tematica.id = preguntas.id_tematica limit $inicio, $filas");
            while ($registro = $res->fetch(PDO::FETCH_OBJ)) {
                $preguntas = new pregunta($registro->id_pregunta, $registro->enunciado_pregunta, $registro->id_respuesta_correcta, $registro->recurso, $registro->tema, null);
                $registros[] = $preguntas;
            }
        }
        return $registros;
    }


    public static function selectPreguntaId($clave):array
    {
        $vector = [];
        $resultado = self::$con->query("SELECT respuestas.id as id_respuesta, respuestas.enunciado as enunciado_respuesta, tematica.id as id_tematica, tematica.tema, preguntas.id as id_pregunta, preguntas.enunciado as enunciado_pregunta, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM respuestas INNER JOIN preguntas on respuestas.id_pregunta = preguntas.id inner join tematica on tematica.id = preguntas.id_tematica WHERE id_pregunta = '${clave}'");
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
                
                $enunTema = utf8_encode($registro->tema);

                $w = $registro->id_respuesta_correcta;
                $resultado3 = self::$con->query("SELECT * FROM respuestas WHERE id ='${w}'");
                $respuesta_correcta=null;
                while ($registro3 = $resultado3->fetch(PDO::FETCH_OBJ))
                {
                    $respuesta_correcta = $registro3;
                }
                $enunResp = utf8_encode($respuesta_correcta->enunciado);

                $tematica = new tematica($registro->id_tematica, $enunTema);
                $respuesta = new respuesta($registro->id_respuesta_correcta, $enunResp, $registro->id_pregunta);
                $id_pregunta = new pregunta($registro->id_pregunta, $enunPreg, $respuesta, $registro->recurso, $tematica, $vectorResp);
                $vector [$registro->id_pregunta] = $id_pregunta;
            }
            
        }

        return $vector;
    }

    public static function selectPreguntaEnunciado($clave):array
    {
        $vector = [];
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $resultado = self::$con->query("SELECT respuestas.id as id_respuesta, respuestas.enunciado as enunciado_respuesta, tematica.id as id_tematica, tematica.tema, preguntas.id as id_pregunta, preguntas.enunciado as enunciado_pregunta, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM respuestas INNER JOIN preguntas on respuestas.id_pregunta = preguntas.id inner join tematica on tematica.id = preguntas.id_tematica WHERE preguntas.enunciado = '${clave}'");
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

                $tematica = new tematica($registro->id_tematica, $registro->tema);
                $respuesta = new respuesta($registro->id_respuesta, $registro->enunciado_respuesta, $registro->id_pregunta);
                $id_pregunta = new pregunta($registro->id_pregunta, $registro->enunciado_pregunta, $respuesta, $registro->recurso, $tematica, $vectorResp);
                $vector [$registro->id_pregunta] = $id_pregunta;
            }
            
        }

        return $vector;
    }
    public static function selectPreguntaEnunciadoPeq($clave)
    {
        $vector = false;
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $resultado = self::$con->query("SELECT id from preguntas where enunciado = '${clave}'");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $vector = $registro->id;
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

    public static function actualizaPregunta($pregunta)
    {
        $enunciado = $pregunta->getEnunciado();
        $id_respuesta_correcta = $pregunta->getId_respuesta_correcta();
        $recurso = $pregunta->getRecurso();
        $id_tematica = $pregunta->getId_tematica();
        $id = $pregunta->getId();

        if($recurso==NULL)
        {
            $string = "UPDATE preguntas SET enunciado = '${enunciado}', id_respuesta_correcta = '${id_respuesta_correcta}', id_tematica = '${id_tematica}' WHERE id = '${id}'";
        }
        
        if($id_respuesta_correcta==NULL)
        {
            $string = "UPDATE preguntas SET enunciado = '${enunciado}', recurso = '${recurso}', id_tematica = '${id_tematica}' WHERE id = '${id}'";
        }
        if($recurso==NULL && $id_respuesta_correcta==NULL)
        {
            $string = "UPDATE preguntas SET enunciado = '${enunciado}', id_tematica = '${id_tematica}' WHERE id = '${id}'";
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

    public static function selectExamenId2($clave):array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT * FROM examen where id = '${clave}'");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $examen = new examen($registro->id, $registro->descripcion, $registro->duracion, $registro->num_preguntas, $registro->activo);
            $vector [] = $examen;
        }

        return $vector;
    }

    // SELECT respuestas.id as id_respuesta, respuestas.enunciado as enunciado_respuesta, tematica.id as id_tematica, tematica.tema, preguntas.id as id_pregunta, preguntas.enunciado as enunciado_pregunta, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM respuestas INNER JOIN preguntas on respuestas.id_pregunta = preguntas.id inner join tematica on tematica.id = preguntas.id_tematica inner join examen_pregunta on examen_pregunta.id_pregunta = preguntas.id WHERE examen_pregunta.id_examen = '${clave}'
    public static function selectExamenId($clave):array
    {
        $vector = [];
        $resultado = self::$con->query("SELECT respuestas.id as id_respuesta, respuestas.enunciado as enunciado_respuesta, tematica.id as id_tematica, tematica.tema, preguntas.id as id_pregunta, preguntas.enunciado as enunciado_pregunta, preguntas.id_respuesta_correcta, preguntas.recurso, preguntas.id_tematica FROM respuestas INNER JOIN preguntas on respuestas.id_pregunta = preguntas.id inner join tematica on tematica.id = preguntas.id_tematica inner join examen_pregunta on examen_pregunta.id_pregunta = preguntas.id where examen_pregunta.id_examen = '${clave}'");
        $rep = "";
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $idPreg = $registro->id_pregunta;
            
            if($idPreg!=$rep)
            {
                $resultado2 = self::$con->query("SELECT * FROM respuestas WHERE id_pregunta ='${idPreg}'");
                $vectorResp = [];
                while ($registro2 = $resultado2->fetch(PDO::FETCH_OBJ))
                {
                    $respuesta2 = new respuesta($registro2->id, utf8_encode($registro2->enunciado), $registro2->id_pregunta);
                    $vectorResp[] = $respuesta2;
                    // var_dump($registro2);
                    // $vectorResp[] = $registro2->id;
                }
                $rep = $idPreg;
                $enunPreg = utf8_encode($registro->enunciado_pregunta);
                $enunResp = utf8_encode($registro->enunciado_respuesta);
                $enunTema = utf8_encode($registro->tema);

                shuffle($vectorResp);
                $tematica = new tematica($registro->id_tematica, $enunTema);
                $respuesta = new respuesta($registro->id_respuesta, $enunResp, $registro->id_pregunta);
                $id_pregunta = new pregunta($registro->id_pregunta, $enunPreg, $respuesta, $registro->recurso, $tematica, $vectorResp);
                $vector [$registro->id_pregunta] = $id_pregunta;
            }
            
        }

        shuffle($vector);
        return $vector;
    }

    public static function selectExamenDescripcion($descripcion)
    {
        $vector = false;
        $resultado = self::$con->query("SELECT * FROM examen WHERE descripcion = '${descripcion}'");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $examen = new examen($registro->id, $registro->descripcion, $registro->duracion, $registro->num_preguntas, $registro->activo);
            $vector = $examen;
        }

        return $vector;
    }

    public static function obtenExamenesPaginados(int $pagina, int $filas):array
    {
        $registros = array();
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $res = self::$con->query("select * from examen");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res = self::$con->query("select * from examen limit $inicio, $filas");
            while ($registro = $res->fetch(PDO::FETCH_OBJ)) {
                if($registro->activo==1)
                {
                    $registro->activo="SI";
                }
                else{
                    $registro->activo="NO";
                }
                $examen = new examen($registro->id, $registro->descripcion, $registro->duracion, $registro->num_preguntas, $registro->activo);
                $registros[] = $examen;
            }
        }
        return $registros;
    }

    public static function obtenExamenesPaginadosA(int $pagina, int $filas):array
    {
        $registros = array();
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $res = self::$con->query("select * from examen");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res = self::$con->query("select * from examen where activo=1 limit $inicio, $filas");
            while ($registro = $res->fetch(PDO::FETCH_OBJ)) {
                if($registro->activo==1)
                {
                    $registro->activo="SI";
                }
                else{
                    $registro->activo="NO";
                }
                $examen = new examen($registro->id, $registro->descripcion, $registro->duracion, $registro->num_preguntas, $registro->activo);
                $registros[] = $examen;
            }
        }
        return $registros;
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

    public static function desactivaExamen($id, $valor)
    {
        $string = "UPDATE examen SET activo = '${valor}' WHERE id = '${id}';";
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
        $id_examen = $id_examen->getId();
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

    public static function selectEjecucionExamenUsuario($id):array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT ejecucion FROM examen_usuario where id = '${id}'");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $vector [0] = $registro->ejecucion;
        }

        return $vector;
    }

    public static function selectExamenUsuarioId($clave):array
    {
        $vector = array();
        $resultado = self::$con->query("SELECT examen.* FROM examen_usuario inner join examen on examen.id=examen_usuario.id_examen where examen_usuario.id = '${clave}'");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $examen = new examen($registro->id, $registro->descripcion, $registro->duracion, $registro->num_preguntas, $registro->activo);
            $vector [] = $examen;
        }

        return $vector;
    }

    public static function obtenExamenesUsuariosPaginados(int $pagina, int $filas):array
    {
        $registros = array();
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $res = self::$con->query("select * from examen_usuario");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res = self::$con->query("select examen_usuario.*, usuarios.correo as correo_usuario, examen.descripcion as nombre_examen from examen_usuario inner join examen on examen.id=examen_usuario.id_examen inner join usuarios on usuarios.id=examen_usuario.id_usuario limit $inicio, $filas");
            while ($registro = $res->fetch(PDO::FETCH_OBJ)) {
                $examen = new examen_usuario($registro->id, $registro->nombre_examen, $registro->correo_usuario, $registro->fecha, $registro->calificacion, $registro->ejecucion);
                $registros[] = $examen;
            }
        }
        return $registros;
    }

    public static function obtenExamenesUsuariosPaginadosAlumno(int $pagina, int $filas, $cor):array
    {
        $registros = array();
        $tildes = self::$con->query("SET NAMES 'utf8'");
        $res = self::$con->query("select * from examen_usuario");
        $registros =$res->fetchAll();
        $total = count($registros);
        $paginas = ceil($total /$filas);
        $registros = array();
        if ($pagina <= $paginas)
        {
            $inicio = ($pagina-1) * $filas;
            $res = self::$con->query("select examen_usuario.*, usuarios.correo as correo_usuario, examen.descripcion as nombre_examen from examen_usuario inner join examen on examen.id=examen_usuario.id_examen inner join usuarios on usuarios.id=examen_usuario.id_usuario where usuarios.correo = '${cor}' limit $inicio, $filas");
            while ($registro = $res->fetch(PDO::FETCH_OBJ)) {
                $examen = new examen_usuario($registro->id, $registro->nombre_examen, $registro->correo_usuario, $registro->fecha, $registro->calificacion, $registro->ejecucion);
                $registros[] = $examen;
            }
        }
        return $registros;
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
        $id_examen = $id_examen->getId();
        $id_usuario = $examen_usuario->getId_usuario();
        $id_usuario = $id_usuario->getId();
        $calificacion = $examen_usuario->getCalificacion();
        $ejecucion = $examen_usuario->getEjecucion();
        $ejecucion = json_encode($ejecucion);
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

    //GENERAL

    public static function cuentaRegistros($tabla)
    {
        $res = array();
        $resultado = self::$con->query("SELECT * FROM ${tabla}");
        while ($registro = $resultado->fetch(PDO::FETCH_OBJ)) {
            $res[] = $registro;
        }

        return count($res);
    }
    
}
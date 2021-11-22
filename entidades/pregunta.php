<?php
class pregunta {
    protected $id;
    protected $enunciado;
    protected respuesta $id_respuesta_correcta;
    protected $recurso;
    protected tematica $id_tematica;
    
    public function __construct($id, $enunciado, $id_respuesta_correcta, $recurso, $id_tematica) 
    {
        $this->id = $id;
        $this->enunciado = $enunciado;
        $this->id_respuesta_correcta = $id_respuesta_correcta;
        $this->recurso = $recurso;
        $this->id_tematica = $id_tematica;
    }

    public function getId() {return $this->id; }
    public function getEnunciado() {return $this->enunciado; }
    public function getId_respuesta_correcta() {return $this->id_respuesta_correcta; }
    public function getRecurso() {return $this->recurso; }
    public function getId_tematica() {return $this->id_tematica; }
}
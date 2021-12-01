<?php
class pregunta implements JsonSerializable{
    protected $id;
    protected $enunciado;
    protected $id_respuesta_correcta; //objeto respuesta
    protected $recurso;
    protected $id_tematica; //objeto temtica
    protected $vectorRespuestas; //guardaremos las respuestas que tiene la pregunta
    
    public function __construct($id, $enunciado, $id_respuesta_correcta, $recurso, $id_tematica, $vectorRespuestas) 
    {
        $this->id = $id;
        $this->enunciado = $enunciado;
        $this->id_respuesta_correcta = $id_respuesta_correcta;
        $this->recurso = $recurso;
        $this->id_tematica = $id_tematica;
        $this->vectorRespuestas = $vectorRespuestas;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
    
    public function getId() {return $this->id; }
    public function getEnunciado() {return $this->enunciado; }
    public function getId_respuesta_correcta() {return $this->id_respuesta_correcta; }
    public function getRecurso() {return $this->recurso; }
    public function getId_tematica() {return $this->id_tematica; }
    public function getVectorRespuestas() {return $this->vectorRespuestas; }

    public function setId($id){
        $this->id = $id;
     }
}
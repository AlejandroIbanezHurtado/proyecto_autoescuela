<?php
class respuesta {
    protected $id;
    protected $enunciado;
    protected $id_pregunta;
    
    public function __construct($id, $enunciado, $id_pregunta) 
    {
        $this->id = $id;
        $this->enunciado = $enunciado;
        $this->id_pregunta = $id_pregunta;
    }

    public function getId() {return $this->id; }
    public function getEnunciado() {return $this->enunciado; }
    public function getId_pregunta() {return $this->id_pregunta; }
}
<?php
class examen_pregunta {
    protected $id_examen;//objeto examen
    protected $id_pregunta;//objeto pregunta
    
    public function __construct($id_examen, $id_pregunta) 
    {
        $this->id_examen = $id_examen;
        $this->id_pregunta = $id_pregunta;
    }

    public function getId_examen() {return $this->id_examen; }
    public function getId_pregunta() {return $this->id_pregunta; }
}
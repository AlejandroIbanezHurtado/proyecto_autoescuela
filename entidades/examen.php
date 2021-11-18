<?php
class examen {
    protected $id;
    protected $descripcion;
    protected $duracion;
    protected $num_preguntas;
    protected $activo;
    
    public function __construct($id, $descripcion, $duracion, $num_preguntas, $activo) 
    {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->duracion = $duracion;
        $this->num_preguntas = $num_preguntas;
        $this->activo = $activo;
    }

    public function getId() {return $this->id; }
    public function getDescripcion() {return $this->descripcion; }
    public function getDuracion() {return $this->duracion; }
    public function getNum_preguntas() {return $this->num_preguntas; }
    public function getActivo() {return $this->activo; }
}
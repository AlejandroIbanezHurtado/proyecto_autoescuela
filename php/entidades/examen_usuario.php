<?php
class examen_usuario implements JsonSerializable{//este sera el registro de examenes de cada usuario
    protected $id;
    protected $id_examen;//objeto examen
    protected $id_usuario;//objeto usuario
    protected $fecha;
    protected $calificacion;
    protected $ejecucion;
    
    public function __construct($id, $id_examen, $id_usuario, $fecha, $calificacion, $ejecucion) 
    {
        $this->id = $id;
        $this->id_examen = $id_examen;
        $this->id_usuario = $id_usuario;
        $this->fecha = $fecha;
        $this->calificacion = $calificacion;
        $this->ejecucion = $ejecucion;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function getId() {return $this->id; }
    public function getId_examen() {return $this->id_examen; }
    public function getId_usuario() {return $this->id_usuario; }
    public function getFecha() {return $this->fecha; }
    public function getCalificacion() {return $this->calificacion; }
    public function getEjecucion() {return $this->ejecucion; }
}
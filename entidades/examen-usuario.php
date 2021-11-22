<?php
class examen_usuario {
    protected $id;
    protected examen $id_examen;
    protected usuario $id_usuario;
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

    public function getId() {return $this->id; }
    public function getId_examen() {return $this->id_examen; }
    public function getId_usuario() {return $this->id_usuario; }
    public function getFecha() {return $this->fecha; }
    public function getCalificacion() {return $this->calificacion; }
    public function getEjecucion() {return $this->ejecucion; }
}
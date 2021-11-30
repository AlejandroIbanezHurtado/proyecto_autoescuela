<?php
class usuario implements JsonSerializable{
    protected $id;
    protected $correo;
    protected $nombre;
    protected $apellidos;
    protected $password;
    protected $fecha_nac;
    protected $rol;
    protected $imagen;
    
    public function __construct($id, $correo, $nombre, $apellidos, $password, $fecha_nac, $rol, $imagen) 
    {
        $this->id = $id;
        $this->correo = $correo;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->password = $password;
        $this->fecha_nac = $fecha_nac;
        $this->rol = $rol;
        $this->imagen = $imagen;
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }

    public function getId() {return $this->id; }
    public function getCorreo() {return $this->correo; }
    public function getNombre() {return $this->nombre; }
    public function getApellidos() {return $this->apellidos; }
    public function getPassword() {return $this->password; }
    public function getFecha_nac() {return $this->fecha_nac; }
    public function getRol() {return $this->rol; }
    public function getImagen() {return $this->imagen; }
}
<?php
class tematica implements JsonSerializable{
    protected $id;
    protected $tema;
    
    public function __construct($id, $tema) 
    {
        $this->id = $id;
        $this->tema = $tema;
        
    }

    public function jsonSerialize() {
        return get_object_vars($this);
    }
    
    public function getId() {return $this->id; }
    public function getTema() {return $this->tema; }
 
}
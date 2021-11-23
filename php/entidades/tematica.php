<?php
class tematica {
    protected $id;
    protected $tema;
    
    public function __construct($id, $tema) 
    {
        $this->id = $id;
        $this->tema = $tema;
        
    }

    public function getId() {return $this->id; }
    public function getTema() {return $this->tema; }
 
}
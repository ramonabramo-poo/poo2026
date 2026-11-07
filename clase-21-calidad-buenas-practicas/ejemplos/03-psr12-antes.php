<?php
// ❌ Este archivo funciona, pero NO sigue PSR-12. ¿Cuántos fallos encontráis?
class producto{
  public $Nombre;
  private $precio;
    function __construct($n,$p){$this->Nombre=$n;$this->precio=$p;}
  public function PrecioConIva()
  {
    if($this->precio>0){ return $this->precio*1.21; }
    else return 0;
  }
}
$p=new producto("Taza",7.95);echo $p->PrecioConIva();

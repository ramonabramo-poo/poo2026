<?php
// Ejercicio 01: este código funciona, pero cuesta entenderlo. Refactorizadlo.
function f($a){$r=[];foreach($a as $x){if($x['n']>=5){$r[]=$x['nom'];}}return $r;}
function g($a){$s=0;foreach($a as $x){$s=$s+$x['n'];}return $s/count($a);}
$l=[['nom'=>'Marta','n'=>8.5],['nom'=>'Luis','n'=>4.2],['nom'=>'Ana','n'=>9.25]];
echo implode(', ',f($l)).' | '.round(g($l),2);

<?php
// Escribid antes vuestra predicción y comprobadla después
var_dump("10" + 5);        // int(15)
echo "<br>";
var_dump("10" . 5);        // string(3) "105"
echo "<br>";
var_dump((int) "3.99");    // int(3)
echo "<br>";
var_dump((bool) "0");      // bool(false)
echo "<br>";
var_dump(10 == "10");      // bool(true)
echo "<br>";
var_dump(10 === "10");     // bool(false)

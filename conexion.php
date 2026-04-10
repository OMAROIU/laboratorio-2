<?php
//mysqli o pdo 

$host = "localhost";
$user = "root";
$pass = "Omargarcia2002"; 
$base = "laboratorio2";        

// Aquí cambiamos $bab por $base para que coincida
$conexion = new mysqli($host, $user, $pass, $base); 

if ($conexion->connect_error){
    die("Error de conexion: " . $conexion->connect_error);
}

?>
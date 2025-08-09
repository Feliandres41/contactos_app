<?php
$servidor = "localhost";
$base_datos = "contactos";
$usuario = "zack";
$password = "5204";

try {
    $conexion = new PDO("mysql:host=$servidor;dbname=$base_datos", $usuario, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $info = "Conexión exitosa"; 
} catch(PDOException $e) {
    $info = "Conexión fallida: " . $e->getMessage();
    die($info); // Detiene la ejecución si no hay conexión
}
?>
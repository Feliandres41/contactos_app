<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}
require_once "./includes/conexión_PDO.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['agregar_contacto'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $nombre = $_POST['nombre_contacto'];
    $telefono = $_POST['telefono_contacto'];
    $email = $_POST['email_contacto'];
    $fecha = date('Y-m-d H:i:s');

    try {
        $sql = "INSERT INTO contactos (usuario_id, nombre, telefono, email, fecha_creación) VALUES (:usuario_id, :nombre, :telefono, :email, :fecha)";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':fecha', $fecha); 
        
        $stmt->execute();
        
        header("Location: interfaz.php");
        exit();
    } catch(PDOException $e) {
        echo "<p style='color:red;'>Error al agregar el contacto: " . $e->getMessage() . "</p>";
    }
}
?>
<h1>Agregar Nuevo Contacto</h1>
<form action="" method="POST">
    <label for="nombre_contacto">Nombre:</label><br>
    <input type="text" id="nombre_contacto" name="nombre_contacto" required><br><br>
    <label for="telefono_contacto">Teléfono:</label><br>
    <input type="tel" id="telefono_contacto" name="telefono_contacto"><br><br>
    <label for="email_contacto">Correo electrónico:</label><br>
    <input type="email" id="email_contacto" name="email_contacto" required><br><br>
    <button type="submit" name="agregar_contacto">Guardar Contacto</button>
</form>
<br><a href="interfaz.php">Volver a mis contactos</a>
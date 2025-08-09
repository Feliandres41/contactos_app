<?php
session_start();
require_once "./includes/conexión_PDO.php";
$valida = false;
$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['email'] ?? '';
    $contrasena = $_POST['password'] ?? '';
    $fecha = date('Y-m-d H:i:s');

    try {
        $stmt = $conexion->prepare("SELECT email FROM usuarios WHERE email = :email");
        $stmt->bindParam(':email', $correo);
        $stmt->execute();
        if ($stmt->fetch(PDO::FETCH_ASSOC)) {
            $valida = true;
            $mensaje = "Este correo ya está registrado, ingrese otro nuevamente.";
        } else {
            $sql = "INSERT INTO usuarios(nombre, email, password, fecha_creación) VALUES (:nombre, :email, :contrasena, :fecha)";
            $stmt = $conexion->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':email', $correo);
            $stmt->bindParam(':contrasena', $contrasena);
            $stmt->bindParam(':fecha', $fecha);
            if ($stmt->execute()) {
                $mensaje = "Nuevo registro creado exitosamente";
            } else {
                $mensaje = "Error al crear el registro.";
            }
        }
    } catch(PDOException $e) {
        $mensaje = "Error de base de datos: " . $e->getMessage();
    }
}
?>
<p><?php echo $mensaje; ?></p>
<form action="<?php echo $valida ? 'agregar.php' : 'index.php'; ?>">
    <button><?php echo $valida ? 'Regresar' : 'Iniciar sesión'; ?></button>
</form>
<?php
session_start();
require_once "./includes/conexión_PDO.php";
$mensaje_error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email_ini = $_POST['email_ini'];
    $password_ini = $_POST['password_ini'];
    try {
        $sql = "SELECT id, email FROM usuarios WHERE email = :email AND password = :password";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':email', $email_ini);
        $stmt->bindParam(':password', $password_ini);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['email_ini0'] = $usuario['email'];
            header("Location: interfaz.php");
            exit();
        } else {
            $mensaje_error = "Credenciales incorrectas.";
        }
    } catch(PDOException $e) {
        $mensaje_error = "Error en el inicio de sesión: " . $e->getMessage();
    }
}
?>
<h1>Iniciar sesión</h1>
<form action="" method="POST">
    <label for="email_ini">Correo electrónico:</label>
    <input type="email" id="email_ini" name="email_ini" required><br><br>
    <label for="password_ini">Contraseña:</label>
    <input type="password" id="password_ini" name="password_ini" required><br><br>
    <button type="submit" name="login">Iniciar sesión</button>
</form>
<form action="agregar.php">
    <button type="submit">Crear cuenta</button>
</form>
<?php
if ($mensaje_error) {
    echo "<br><p style='color:red;'>$mensaje_error</p>";
}
?>
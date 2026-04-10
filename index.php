<?php
session_start();
require_once 'conexion.php'; 

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // 1. Intentar Loguear primero
    $stmt = $conexion->prepare("SELECT id, password FROM usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $user = $resultado->fetch_assoc();

    if ($user) {
        // Validación flexible: acepta texto plano (para pruebas rápidas) o encriptado
        if ($password == $user['password'] || password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php");
            exit;
        } else {
            $mensaje = "<p class='error'>Contraseña incorrecta.</p>";
        }
    } else {
        // 2. Si el usuario no existe, ofrecer registrarlo (Punto 1 del Lab)
        if (isset($_POST['accion']) && $_POST['accion'] == 'registrar') {
            // Guardamos la contraseña tal cual para que no tengas problemas al entrar
            $stmt_reg = $conexion->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
            $stmt_reg->bind_param("ss", $usuario, $password);
            if($stmt_reg->execute()){
                $mensaje = "<p style='color:green; text-align:center;'>¡Registro exitoso! Ya puedes ingresar.</p>";
            }
        } else {
            $mensaje = "<p class='error'>El usuario no existe. Haz clic en 'Registrar' para crearlo.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login </title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 300px; }
        h2 { text-align: center; color: #004a99; }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #004a99; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 5px; }
        .btn-reg { background: #28a745; }
        button:hover { opacity: 0.9; }
        .error { color: red; font-size: 14px; text-align: center; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <?php echo $mensaje; ?>
        <form method="POST">
            <input type="text" name="usuario" placeholder="Nombre de usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            
            <button type="submit" name="accion" value="login">Ingresar</button>
            <button type="submit" name="accion" value="registrar" class="btn-reg">Registrar Usuario</button>
        </form>
    </div>
</body>
</html>
<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Procesar el formulario de ingreso de datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validación de datos [cite: 8]
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $cantidad = intval($_POST['cantidad']);

    if (!empty($nombre) && $cantidad > 0) {
        $stmt = $conexion->prepare("INSERT INTO registros (nombre_item, cantidad) VALUES (?, ?)");
        $stmt->bind_param("si", $nombre, $cantidad);
        $stmt->execute();
    }
}

// Obtener datos para la tabla [cite: 7]
$query = "SELECT * FROM registros ORDER BY fecha_registro DESC";
$resultado_tabla = $conexion->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Datos</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background-color: #fafafa; }
        .container { max-width: 800px; margin: auto; background: white; padding: 20px; border-radius: 8px; border-top: 5px solid #004a99; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #004a99; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .form-add { margin-bottom: 30px; padding: 15px; background: #e9ecef; border-radius: 5px; }
        .logout { float: right; color: red; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <a href="logout.php" class="logout">Cerrar Sesión</a>
        <h2>Gestión de Registros</h2>

        <div class="form-add">
            <h4>Agregar nuevo dato</h4>
            <form method="POST">
                <input type="text" name="nombre" placeholder="Ej. Laptop Dell" required>
                <input type="number" name="cantidad" placeholder="Cantidad" required>
                <button type="submit" style="background:#28a745; color:white; border:none; padding:8px 15px; border-radius:4px; cursor:pointer;">Guardar</button>
            </form>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Descripción</th>
                    <th>Cantidad</th>
                    <th>Fecha de Registro</th>
                </tr>
            </thead>
            <tbody>
                <?php while($fila = $resultado_tabla->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $fila['id']; ?></td>
                    <td><?php echo htmlspecialchars($fila['nombre_item']); ?></td>
                    <td><?php echo $fila['cantidad']; ?></td>
                    <td><?php echo $fila['fecha_registro']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
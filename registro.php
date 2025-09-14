<?php
session_start(); // Iniciar sesión para manejar usuario

// Mostrar errores
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Conexión con XAMPP (puerto 3308)
$conexion = mysqli_connect("127.0.0.1", "root", "", "usuariosdb", 3308);
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
mysqli_set_charset($conexion, "utf8mb4");

$registro_exitoso = false;
$mensaje_error = "";

// Guardar usuario
if (isset($_POST['registrar'])) {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    // Verificar si el usuario ya existe
    $resultado = mysqli_query($conexion, "SELECT * FROM usuarios WHERE nombre='$nombre'");
    if (mysqli_num_rows($resultado) > 0) {
        $mensaje_error = "<p style='color:red;'>Usuario en uso ❌</p>";
    } else {
        mysqli_query($conexion, "INSERT INTO usuarios (nombre, contrasena) VALUES ('$nombre', '$contrasena')");
        $registro_exitoso = true;
        $_SESSION['usuario'] = $nombre; // Guardar usuario en sesión
        echo "<p style='color:green;'>Usuario registrado con éxito ✅</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f0f8ff; display:flex; justify-content:center; align-items:center; height:100vh; flex-direction: column; }
        form { background:#fff; padding:20px; border-radius:8px; box-shadow:0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px; }
        input { margin:10px 0; padding:8px; width:100%; }
        button { padding:10px; background:#007BFF; color:white; border:none; cursor:pointer; width:100%; border-radius:5px; }
        button:hover { background:#0056b3; }
        .volver-btn { background:#28a745; width:auto; padding:10px 20px; margin-top:10px; }
        .volver-btn:hover { background:#1e7e34; }
    </style>
</head>
<body>
    <?php if (!$registro_exitoso): ?>
    <form method="POST">
        <h2>Registro de Usuario</h2>
        <?php echo $mensaje_error; ?>
        <input type="text" name="nombre" placeholder="Nombre de usuario" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit" name="registrar">Registrarse</button>
    </form>
    <?php else: ?>
        <h2>¡Bienvenido, <?php echo $_SESSION['usuario']; ?>! ✅</h2>
        <button class="volver-btn" onclick="window.location.href='index.html'">Volver a la página</button>
    <?php endif; ?>
</body>
</html>

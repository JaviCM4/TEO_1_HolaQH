<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="./css/sesion.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php require_once '../views/barra.php' ?>
    <div class="body-sesion">
        <div class="login-container">
            <h2>Iniciar Sesión</h2>
            <form class="login-form" action="../servers/credencialServer.php" method="POST">
                <input type="hidden" name="action" value="validar">
                <label for="usuario">Usuario:</label>
                <input type="text" name="usuario" required>
                <br>
                <label for="clave">Contraseña:</label>
                <input type="password" name="clave" required>
                <?php if (isset($_GET['error'])): ?>
                    <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
                <?php endif; ?>
                <br>
                <button type="submit">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
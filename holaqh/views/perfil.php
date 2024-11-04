<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link rel="stylesheet" href="./css/perfil.css">
</head>
<body class="perfil-body">
    <?php require_once '../views/barra.php' ?>

    <div class="contenedor-principal">
    <?php
        $perfil = $_SESSION['perfil'] ?? [];
        unset($_SESSION['perfil']);

        if (empty($perfil)): ?>
            <div class="form-creacion-actualizacion ">
                <h2>Formulario Administrador</h2>
                <form action="../servers/trabajadorServer.php" method="POST">
                    <input type="hidden" name="action" value="crear">
                    
                    <label for="usuario">Usuario:</label>
                    <input type="text" name="usuario" required>

                    <label for="nombres">Nombres:</label>
                    <input type="text" name="nombres" required>

                    <label for="apellidos">Apellidos:</label>
                    <input type="text" name="apellidos" required>

                    <label for="correo">Correo:</label>
                    <input type="text" name="correo" required>

                    <label for="telefono">Telefóno:</label>
                    <input type="number" name="telefono" required>

                    <label for="clave">Contraseña:</label>
                    <input type="password" name="clave" required>

                    <button id="boton-enviar" class="button" type="submit">Crear Administrador</button>
                </form>
            </div>
        <?php else: ?>
            <div class="form-creacion-actualizacion ">
                <?php if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(2, $_SESSION['rol'])): ?>
                    <h2>Información Usuario</h2>
                    <form action="../servers/credencialServer.php" method="POST">
                        <input type="hidden" name="action" value="actualizar-dos">

                        <label for="nombre">Nombre:</label>
                        <input type="text" name="nombre" value="<?= htmlspecialchars($perfil['nombre'] ?? '') ?>" required>

                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" value="<?= htmlspecialchars($perfil['correo'] ?? '') ?>" required>

                        <label for="telefono">Telefono:</label>
                        <input type="number" name="telefono" value="<?= htmlspecialchars($perfil['telefono'] ?? '') ?>" required>

                        <label for="direccion">Dirección:</label>
                        <input type="text" name="direccion" value="<?= htmlspecialchars($perfil['direccion'] ?? '') ?>" required>

                        <label for="clave">Cambie la Contraseña si Desea:</label>
                        <input type="password" name="clave">

                        <button id="boton-enviar" class="button" type="submit">Actualizar Usuario</button>
                    </form>
                <?php else: ?> 
                    <h2>Información Usuario</h2>
                    <form action="../servers/credencialServer.php" method="POST">
                        <input type="hidden" name="action" value="actualizar-uno">

                        <label for="nombres">Nombres:</label>
                        <input type="text" name="nombres" value="<?= htmlspecialchars($perfil['nombres'] ?? '') ?>" required>

                        <label for="apellidos">Apellidos:</label>
                        <input type="text" name="apellidos" value="<?= htmlspecialchars($perfil['apellidos'] ?? '') ?>" required>

                        <label for="correo">Correo:</label>
                        <input type="email" name="correo" value="<?= htmlspecialchars($perfil['correo'] ?? '') ?>" required>

                        <label for="telefono">Telefóno:</label>
                        <input type="number" name="telefono" value="<?= htmlspecialchars($perfil['telefono'] ?? '') ?>" required>

                        <label for="clave">Cambie la Contraseña si Desea:</label>
                        <input type="password" name="clave">

                        <button id="boton-enviar" class="button" type="submit">Actualizar Usuario</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endif; 
    ?>
    </div>
</body>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Formulario de Anunciante</title>
        <link rel="stylesheet" href="./css/crearConsumidor.css">
    </head>
    <body class="crear-consumidor-body">
        <?php require_once '../views/barra.php' ?>

        <div class="orientacion-horizontal">

            <div class="form-seleccion">
                <h3>Selecciona tu tipo de usuario:</h3>
                <form id="formulario-tipo">
                    <label for="tipoUsuario">Tipo de usuario:</label>
                    <select id="tipoUsuario" name="tipoUsuario">
                        <option value="cliente">Cliente</option>
                        <option value="anunciante">Anunciante</option>
                    </select>
                </form>
            </div>

            <!-- Formulario de un Nuevo Cliente -->
            <div id="formulario-cliente" class="form-creacion">
                <h2>Cuenta "Cliente"</h2>
                <form action="../servers/clienteServer.php" method="POST">
                    <input type="hidden" name="action" value="crear">

                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" name="usuario" required>

                    <label for="nombres">Nombres:</label>
                    <input type="text" name="nombres" required>

                    <label for="apellidos">Apellidos:</label>
                    <input type="text" name="apellidos" required>

                    <label for="edad">Edad:</label>
                    <div id="edadesInput" class="orientacion-horizontal">
                        <label>
                            <input type="radio" name="edad" value="1"> 0 - 13 años
                        </label>
                        <label>
                            <input type="radio" name="edad" value="2"> 13 - 18 años
                        </label>
                        <label>
                            <input type="radio" name="edad" value="3"> 18 años en adelante
                        </label>
                    </div>

                    <div class="orientacion-horizontal">
                        <div class="orientacion-vertical">
                            <label for="correo">Correo:</label>
                            <input id="correoInput" type="email" name="correo" required>
                        </div>
                        <div class="orientacion-vertical">
                            <label for="telefono">Teléfono:</label>
                            <input id="telefonoInput" type="number" name="telefono" required>
                        </div>
                    </div>

                    <label for="clave">Contraseña:</label>
                    <input type="password" name="clave" required>

                    <button class="button" type="submit">Crear Cuenta</button>
                </form>
            </div>

            <!-- Formulario de un Nuevo Anunciante -->
            <div id="formulario-anunciante" class="form-creacion">
                <h2>Cuenta "Anunciante"</h2>
                <form action="../servers/anuncianteServer.php" method="POST">
                    <input type="hidden" name="action" value="crear">

                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" name="usuario" required>

                    <label for="nombre">Nombre de la Empresa:</label>
                    <input type="text" name="nombre" required>

                    <div class="orientacion-horizontal">
                        <div class="orientacion-vertical">
                            <label for="correo">Correo:</label>
                            <input id="correoInputDos" type="email" name="correo" required>
                        </div>
                        <div class="orientacion-vertical">
                            <label for="telefono">Teléfono:</label>
                            <input id="telefonoInputDos" type="number" name="telefono" required>
                        </div>
                    </div>

                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" required>

                    <label for="clave">Contraseña:</label>
                    <input type="password" name="clave" required>

                    <button class="button" type="submit">Crear Cuenta</button>
                </form>
            </div>
        </div>
        <script src="./js/crearConsumidor.js"></script>
    </body>
</html>

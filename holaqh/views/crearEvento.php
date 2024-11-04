<head>
    <meta charset="UTF-8">
    <title>Evento</title>
    <link rel="stylesheet" href="./css/crearEvento.css">
</head>
<body class="crear-evento-body">
    <?php require_once '../views/barra.php' ?>

    <div class="contenedor-principal">
        <div class="contenedor-enlaces">
            <a id="boton-separacion" class="button" href="../servers/eventoServer.php?action=futuros">Eventos Próximos</a>
            <a class="button" href="../servers/eventoServer.php?action=pasados">Eventos Pasados</a>
            <div class="contenedor-enlaces-derechos">
                <a id="boton-crear" class="button" href="../views/crearEvento.php">Crear Evento</a>
            </div>
        </div>
        
        <?php
            $evento = $_SESSION['detalle'] ?? [];
            unset($_SESSION['detalle']);
            
            if (empty($evento)): ?>
                <div class="contenedor-form">
                    <div class="form-creacion-actualizacion ">
                        <h2>Crear Evento</h2>
                        <form action="../servers/eventoServer.php" method="POST">
                            <input type="hidden" name="action" value="crear">

                            <label for="titulo">Nombre del Evento:</label>
                            <input type="text" name="titulo" required>

                            <label for="descripcion">Descripción:</label>
                            <textarea class="areaTexto" name="descripcion" required></textarea>

                            <label for="lugar">Lugar:</label>
                            <input type="text" name="lugar" required>

                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccion" required>

                            <label for="edad">Edad:</label>
                            <div id="edadesInput" class="orientacion-horizontal">
                                <label id="label-radio">
                                    <input type="radio" name="edad" value="1"> Infantil
                                </label>
                                <label id="label-radio">
                                    <input type="radio" name="edad" value="2"> Para toda la Familiar
                                </label>
                                <label id="label-radio">
                                    <input type="radio" name="edad" value="3"> Mayores de Edad
                                </label>
                            </div>

                            <label for="capacidad">Máxima Capacidad de Personas:</label>
                            <input type="number" name="capacidad" required>

                            <div class="orientacion-horizontal">
                                <div class="orientacion-vertical">
                                    <label for="hora">Hora de Inicio del Evento:</label>
                                    <input id="horaInput" type="time" name="hora" required>
                                </div>
                                <div class="orientacion-vertical">
                                    <label for="fecha">Fecha:</label>
                                    <input id="fechaInput" type="date" name="fecha" required>
                                </div>
                            </div>

                            <label for="medio">URL para mayor información</label>
                            <input type="text" name="medio" required>

                            <button id="boton-enviar" class="button" type="submit">Crear Evento</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="contenedor-form">
                    <div class="form-creacion-actualizacion ">
                        <h2>Edición de Evento</h2>
                        <form action="../servers/eventoServer.php" method="POST">
                            <input type="hidden" name="action" value="actualizar">
                            <input type="hidden" name="no_evento" value="<?= htmlspecialchars($evento['no_evento'] ?? '') ?>">

                            <label for="titulo">Nombre del Evento:</label>
                            <input type="text" name="titulo" value="<?= htmlspecialchars($evento['titulo'] ?? '') ?>" required>

                            <label for="descripcion">Descripción:</label>
                            <textarea class="areaTexto" name="descripcion" required><?= htmlspecialchars($evento['descripcion'] ?? '') ?></textarea>

                            <label for="lugar">Lugar:</label>
                            <input type="text" name="lugar" value="<?= htmlspecialchars($evento['lugar'] ?? '') ?>" required>

                            <label for="direccion">Dirección:</label>
                            <input type="text" name="direccion" value="<?= htmlspecialchars($evento['direccion'] ?? '') ?>" required>

                            <label for="edad">Edad:</label>
                            <div id="edadesInput" class="orientacion-horizontal">
                                <label id="label-radio">
                                    <input type="radio" name="edad" value="1" <?= (isset($evento['edad']) && $evento['edad'] == 1) ? 'checked' : '' ?>> Infantil
                                </label id="label-radio">
                                <label>
                                    <input type="radio" name="edad" value="2" <?= (isset($evento['edad']) && $evento['edad'] == 2) ? 'checked' : '' ?>> Para toda la Familiar
                                </label id="label-radio">
                                <label>
                                    <input type="radio" name="edad" value="3" <?= (isset($evento['edad']) && $evento['edad'] == 3) ? 'checked' : '' ?>> Mayores de Edad
                                </label>
                            </div>

                            <label for="capacidad">Máxima Capacidad de Personas:</label>
                            <input type="number" name="capacidad" value="<?= htmlspecialchars($evento['capacidad'] ?? '') ?>" required>

                            <div class="orientacion-horizontal">
                                <div class="orientacion-vertical">
                                    <label for="hora">Hora de Inicio del Evento:</label>
                                    <input id="horaInput" type="time" name="hora" value="<?= htmlspecialchars($evento['hora'] ?? '') ?>" required>
                                </div>
                                <div class="orientacion-vertical">
                                    <label for="fecha">Fecha:</label>
                                    <input id="fechaInput" type="date" name="fecha" value="<?= htmlspecialchars($evento['fecha'] ?? '') ?>" required>
                                </div>
                            </div>

                            <label for="medio">URL para mayor información</label>
                            <input type="text" name="medio" value="<?= htmlspecialchars($evento['medio'] ?? '') ?>" required>

                            <button id="boton-enviar" class="button" type="submit">Actualizar Información</button>
                        </form>
                    </div>
                </div>
            <?php endif; 
        ?>
    </div>
</body>
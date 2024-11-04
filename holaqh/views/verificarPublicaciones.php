<head>
    <meta charset="UTF-8">
    <title>Publicaciones por Verificar</title>
    <link rel="stylesheet" href="./css/reporte.css">
</head>
<body class="reporte-body">
    <?php require_once '../views/barra.php' ?>

    <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<div id="mensaje" class="alert alert-danger" role="alert">Mensaje: ' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
        }
        unset($_SESSION['mensaje']);
    ?>

    <?php
        $autorizaciones = $_SESSION['autorizaciones'] ?? [];
        unset($_SESSION['autorizaciones']);
        $detalle = $_SESSION['detalle'] ?? [];
        unset($_SESSION['detalle']);
        $formulario = $_SESSION['formulario'] ?? [];
        unset($_SESSION['formulario']);

        if (!empty($autorizaciones) && empty($detalle) && empty($formulario)) {
            echo '<div class="contenedor-principal">';
            echo '<div class="contenedor-mensajes">';
            echo '<h2>Publicaciones Pendientes de Autorizar</h2>';
            echo '<div id="tab-mensajes" class="tabla-mensajes">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nombre del Evento</th>';
            echo '<th>ID del Anunciante</th>';
            echo '<th>Fecha</th>';
            echo '<th>Opción</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';
            foreach ($autorizaciones as $autorizacion) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($autorizacion['titulo']) . '</td>';
                echo '<td>' . htmlspecialchars($autorizacion['anunciante']) . '</td>';
                echo '<td>' . htmlspecialchars($autorizacion['fecha']) . '</td>';
                echo '<td><a class="button-enlace" href="../servers/eventoServer.php?action=detalleAutorizacion&no=' . htmlspecialchars($autorizacion['no_evento']) . '">Detalle</a></td>';
                echo '</tr>';
            }                      
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else if (!empty($detalle) && empty($autorizaciones) && empty($formulario)) {
            echo '<div class="contenedor-principal">';
            echo '<div class="ficha">';
            echo '<h1>' . htmlspecialchars($detalle['titulo']) . '</h1>';
            if ($detalle['edad'] == 1) {
                echo '<img src="./img/infantil.jpg" alt="Descripción de la imagen" class="imagen-ficha">';
            } else if ($detalle['edad'] == 2) {
                echo '<img src="./img/familiar.jpg" alt="Descripción de la imagen" class="imagen-ficha">';
            } else {
                echo '<img src="./img/mayores.jpg" alt="Descripción de la imagen" class="imagen-ficha">';
            }
            echo '<p><strong>Descripción: </strong>' . htmlspecialchars($detalle['descripcion']) . '</p>';

            echo '<div class="grupo">';
            echo '<h3>Detalles Adicionales:</h3>';
            echo '<p><i class="fas fa-map-marker-alt"></i> <strong>Lugar:</strong> ' . htmlspecialchars($detalle['lugar']) . '</p>';
            echo '<p><i class="fas fa-map-signs"></i> <strong>Dirección:</strong> ' . htmlspecialchars($detalle['direccion']) . '</p>';

            if ($detalle['edad'] == 1) {
                echo '<p><i class="fas fa-child"></i> <strong>Ambiente:</strong> Para Niños</p>';
            } else if ($detalle['edad'] == 2) {
                echo '<p><i class="fas fa-users"></i> <strong>Ambiente:</strong> Familiar</p>';
            } else {
                echo '<p><i class="fas fa-user"></i> <strong>Ambiente:</strong> Para Mayores de Edad</p>';
            }
            echo '<p><i class="fas fa-user-friends"></i> <strong>Capacidad:</strong> ' . htmlspecialchars($detalle['capacidad']) . ' personas</p>';

            echo '<p><i class="fas fa-clock"></i> <strong>Hora:</strong> ' . htmlspecialchars($detalle['hora']) . '</p>';
            echo '<p><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> ' . htmlspecialchars($detalle['fecha']) . '</p>';

            echo '<br><p>Para mayor información visite:</p>';
            echo '<p><i class="fas fa-link"></i> <strong>URL:</strong> ' . htmlspecialchars($detalle['medio']) . '</p>';

            echo '</div>'; // Fin de grupo
            echo '<br>';
            echo '<a class="button" href="../servers/eventoServer.php?action=autorizacion-aprobada&no=' . htmlspecialchars($detalle['no_evento']) . '">Aprobar y Publicar</a>';
            echo '<a id="boton-ignorar" class="button" href="../servers/eventoServer.php?action=denegar&no=' . htmlspecialchars($detalle['no_evento']) . '">Denegar Publicación</a>';
            echo '</div>';
            echo '</div>';
        } else if (!empty($formulario) && empty($detalle) && empty($autorizaciones)) {
            echo '<div class="contenedor-form">';
            echo '<div class="form-reporte">';
            echo '<h2>Publicación Denegada</h2>';
            echo '<form action="../servers/eventoServer.php" method="POST">';
            echo '<input type="hidden" name="action" value="denegar">';
            echo '<input type="hidden" name="no_evento" value="' . htmlspecialchars($_SESSION['no'] ?? '') . '">';

            echo '<label for="descripcion">Escriba un breve comentario del porque la publicación fue rechazada para que el anunciante haga los cambios necesarios para que pueda ser publicado:</label>';
            echo '<textarea class="areaTexto" type="text" name="descripcion" required></textarea>';

            echo '<button class="button" type="submit">Enviar Mensaje</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
            unset($_SESSION['no']);
        } else {
            echo '<div class="contenedor-principal">';
            echo '<div class="contenedor-vacio">';
            echo '<div style="text-align: center;">';
            echo '<h2>No hay Publicaciones Pendientes</h2>';
            echo '<img src="./img/reportes.jpg" width="430" height="360" style="border-radius: 8px; border: 2px solid black;">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    ?>
</body>
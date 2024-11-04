<head>
    <meta charset="UTF-8">
    <title>Reporte Evento</title>
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
        $reportes = $_SESSION['reportes'] ?? [];
        unset($_SESSION['reportes']);
        $reportes_especificos = $_SESSION['reportes_especificos'] ?? [];
        unset($_SESSION['reportes_especificos']);
        $numero = $_SESSION['no'] ?? [];
        unset($_SESSION['no']);
        
        if (empty($reportes) && empty($reportes_especificos) && !empty($numero)) {
            echo '<div class="contenedor-form">';
            echo '<div class="form-reporte">';
            echo '<h2>Reportar Publicación del Evento</h2>';
            echo '<form action="../servers/reporteServer.php" method="POST">';
            echo '<input type="hidden" name="action" value="crear">';
            echo '<input type="hidden" name="no_evento" value="' . htmlspecialchars($numero) . '">';

            echo '<label for="descripcion">Escriba un breve comentario de porque desea reportar esta Publicación:</label>';
            echo '<textarea class="areaTexto" type="text" name="descripcion" required></textarea>';

            echo '<button class="button" type="submit">Enviar Reporte</button>';
            echo '</form>';
            echo '</div>';
            echo '</div>';
        } else if (!empty($reportes) && empty($reportes_especificos)) {
            echo '<div class="contenedor-principal">';
            echo '<div class="contenedor-mensajes">';
            echo '<h2>Reportes</h2>';
            echo '<div id="tab-mensajes" class="tabla-mensajes">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nombre del Evento</th>';
            echo '<th>ID del Anunciante</th>';
            echo '<th>No. de Reportes</th>';
            echo '<th>Opción</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($reportes as $reporte) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($reporte['titulo']) . '</td>';
                echo '<td>' . htmlspecialchars($reporte['anunciante']) . '</td>';
                echo '<td>' . htmlspecialchars($reporte['reportes']) . '</td>';
                echo '<td><a class="button-enlace" href="../servers/reporteServer.php?action=detalle&no=' . htmlspecialchars($reporte['no_evento']) . '">Detalle</a></td>';
                echo '</tr>';
            }
                                
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        } else if (empty($reportes) && !empty($reportes_especificos)) {
            echo '<div class="contenedor-principal">';
            echo '<div class="contenedor-mensajes">';
            echo '<h2>Reportes</h2>';
            echo '<div id="tab-mensajes" class="tabla-mensajes">';
            echo '<table>';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Usuario</th>';
            echo '<th>Descripcion</th>';
            echo '<th>Fecha</th>';
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            foreach ($reportes_especificos as $reporte_especifico) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($reporte_especifico['cliente']) . '</td>';
                echo '<td>' . htmlspecialchars($reporte_especifico['descripcion']) . '</td>';
                echo '<td>' . htmlspecialchars($reporte_especifico['fecha']) . '</td>';
                echo '</tr>';
            }                   
            echo '</tbody>';
            echo '</table>';
            echo '</div><br>';
            echo '</div>';
            echo '</div>';

            //Separación del evento:
            $evento = $_SESSION['evento'] ?? [];
            echo '<div class="contenedor-principal">';
            echo '<div class="ficha">';
            echo '<h1>' . htmlspecialchars($evento['titulo']) . '</h1>';
            if ($evento['edad'] == 1) {
                echo '<img src="./img/infantil.jpg" alt="Descripción de la imagen" class="imagen-ficha">';
            } else if ($evento['edad'] == 2) {
                echo '<img src="./img/familiar.jpg" alt="Descripción de la imagen" class="imagen-ficha">';
            } else {
                echo '<img src="./img/mayores.jpg" alt="Descripción de la imagen" class="imagen-ficha">';
            }
            echo '<p><strong>Descripción: </strong>' . htmlspecialchars($evento['descripcion']) . '</p>';

            echo '<div class="grupo">';
            echo '<h3>Detalles Adicionales:</h3>';
            echo '<p><i class="fas fa-map-marker-alt"></i> <strong>Lugar:</strong> ' . htmlspecialchars($evento['lugar']) . '</p>';
            echo '<p><i class="fas fa-map-signs"></i> <strong>Dirección:</strong> ' . htmlspecialchars($evento['direccion']) . '</p>';

            if ($evento['edad'] == 1) {
                echo '<p><i class="fas fa-child"></i> <strong>Ambiente:</strong> Para Niños</p>';
            } else if ($evento['edad'] == 2) {
                echo '<p><i class="fas fa-users"></i> <strong>Ambiente:</strong> Familiar</p>';
            } else {
                echo '<p><i class="fas fa-user"></i> <strong>Ambiente:</strong> Para Mayores de Edad</p>';
            }
            echo '<p><i class="fas fa-user-friends"></i> <strong>Capacidad:</strong> ' . htmlspecialchars($evento['capacidad']) . ' personas</p>';

            echo '<p><i class="fas fa-clock"></i> <strong>Hora:</strong> ' . htmlspecialchars($evento['hora']) . '</p>';
            echo '<p><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> ' . htmlspecialchars($evento['fecha']) . '</p>';

            echo '<br><p>Para mayor información visite:</p>';
            echo '<p><i class="fas fa-link"></i> <strong>URL:</strong> ' . htmlspecialchars($evento['medio']) . '</p>';

            echo '</div>'; // Fin de grupo
            echo '<br>';
            echo '<a class="button" href="../servers/reporteServer.php?action=aprobar&no=' . htmlspecialchars($evento['no_evento']) . '">Aprobar Reclamos</a>';
            echo '<a id="boton-ignorar" class="button" href="../servers/reporteServer.php?action=ignorar&no=' . htmlspecialchars($evento['no_evento']) . '">Ignorar y Restablecer</a>';
            echo '</div>';
            echo '</div>';
            unset($_SESSION['evento']);
        } else {
            echo '<div class="contenedor-principal">';
            echo '<div class="contenedor-vacio">';
            echo '<div style="text-align: center;">';
            echo '<h2>No hay Reportes</h2>';
            echo '<img src="./img/reportes.jpg" width="430" height="400" style="border-radius: 8px; border: 2px solid black;">';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    ?>
</body>
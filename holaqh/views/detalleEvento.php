<head>
    <meta charset="UTF-8">
    <title>Detalle del Evento</title>
    <link rel="stylesheet" href="./css/detalleEvento.css">
</head>
<body class="detalle-body">
    <?php require_once '../views/barra.php'?>

    <div class="contenedor-principal">
    <?php 
        if (isset($_SESSION['usuario']) && empty($_SESSION['general'])) {
            if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(2, $_SESSION['rol'])) {
                echo '<div class="contenedor-enlaces">';
                echo '<a id="boton-separacion" class="button" href="../servers/eventoServer.php?action=futuros">Eventos Próximos</a>';
                echo '<a class="button" href="../servers/eventoServer.php?action=pasados">Eventos Pasados</a>';
                echo '<div class="contenedor-enlaces-derechos">';
                echo '<a id="boton-crear" class="button" href="../views/crearEvento.php">Crear Evento</a>';
                echo '</div>';
                echo '</div>';
            } else {
                echo '<div class="contenedor-enlaces">';
                echo '<a id="boton-separacion" class="button" href="../servers/asistenciaServer.php?action=futuros">Eventos Próximos</a>';
                echo '<a class="button" href="../servers/asistenciaServer.php?action=pasados">Eventos Pasados</a>';
                echo '</div>';
            }
        }
    ?>

    <?php
        $detalle = $_SESSION['detalle'] ?? [];

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

        echo '</div><br>'; // Fin de grupo
        if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(2, $_SESSION['rol'])) {
            if ($detalle['aprobado'] == 1 || $detalle['editar'] == 1) {
                echo '<a id="boton-separacion" class="button" href="../servers/eventoServer.php?action=actualizar&no=' . htmlspecialchars($detalle['no_evento']) . '">Editar</a>';
            }
            echo '<a id="boton-cancelar-reportar" class="button" href="../servers/eventoServer.php?action=mostrar-delete&no=' . htmlspecialchars($detalle['no_evento']) . '">Eliminar Evento</a>';
        }
        if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(3, $_SESSION['rol'])) {
            if (!isset($_SESSION['general'])) {
                echo '<a id="boton-cancelar-reportar" class="button" href="../servers/asistenciaServer.php?action=eliminar&no=' . htmlspecialchars($detalle['no_evento']) . '">Cancelar Asistencia</a>';
            } else {
                echo '<a id="boton-separacion" class="button" href="../servers/asistenciaServer.php?action=crear&no=' . htmlspecialchars($detalle['no_evento']) . '">Marcar Asistencia</a>';
                echo '<a id="boton-cancelar-reportar" class="button" href="../servers/reporteServer.php?action=mostrar&no=' . htmlspecialchars($detalle['no_evento']) . '">Reportar Evento</a>';
            }
        }
        echo '</div>';
        unset($_SESSION['detalle']);
    ?>
    </div>

    <?php unset($_SESSION['general']); ?>
</body>

<head>
    <meta charset="UTF-8">
    <title>Página General</title>
    <link rel="stylesheet" href="./css/misEventos.css">
</head>
<body class="miseventos-body">
    <?php require_once '../views/barra.php' ?>

    <div class="contenedor-principal">
    <?php 
        if (isset($_SESSION['usuario'])) {
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
        if (isset($_SESSION['mensaje'])) {
            echo '<div id="mensaje" class="alert alert-danger" role="alert">Mensaje: ' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
        }
        unset($_SESSION['mensaje']);
    ?>

    <?php
        $eventos = $_SESSION['eventos'] ?? [];
        
        if (empty($eventos)) {
            echo '<h3>No hay Eventos</h3>';
        } else {
            foreach ($eventos as $evento) {
                echo '<div class="ficha">';
                echo '<h2>' . htmlspecialchars($evento['titulo']) . '</h2>';
                echo '<p><strong>Descripción: </strong>' . htmlspecialchars($evento['descripcion']) . '.</p>';
                echo '<p><strong>Detalles Adicionales:</strong></p>';
                echo '<ul>';
                if (isset($evento['fecha'])) {
                    echo '<li><i class="fas fa-calendar-alt"></i> <strong>Fecha: </strong>' . htmlspecialchars($evento['fecha']) . '</li>';
                }
                echo '<li><i class="fas fa-clock"></i> <strong>Hora: </strong>' . htmlspecialchars($evento['hora']) . '</li>';
                if (isset($evento['faltan'])) {
                    echo '<li><i class="fas fa-calendar-times"></i> <strong>Faltan: </strong>' . htmlspecialchars($evento['faltan']) . ' dia(s) para el Evento</li>';
                }
                if (isset($evento['asistencia'])) {
                    echo '<li><i class="fas fa-check-circle"></i> <strong>Confirmaciones: </strong>' . htmlspecialchars($evento['asistencia']) . ' persona(s) confirmada(s)</li>';
                }
                echo '</ul>';
                if (isset($evento['reportado']) && $evento['reportado'] == 1) {
                    echo '<div class="alert alert-danger" role="alert"><strong>Mensaje:</strong> Esta Publicación ha sido Reportada</div>';
                }
                if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(2, $_SESSION['rol'])) {
                    if (isset($evento['aprobado']) && $evento['aprobado'] == 0) {
                        echo '<div class="alert alert-warning" role="alert"><strong>Mensaje:</strong> Publicación Pendiente de Aprobación</div>';
                    }
                }
                if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(2, $_SESSION['rol'])) {
                    if (isset($evento['bloqueado']) && $evento['bloqueado'] == 1) {
                        echo '<div class="alert alert-danger" role="alert"><strong>Mensaje:</strong> La publicación ha sido bloqueada</div>';
                    }
                }
                
                if (empty($_SESSION['pasado'])) {
                    echo '<br><a id="boton-crear" class="button" href="../servers/eventoServer.php?action=detalle&no=' . htmlspecialchars($evento['no_evento']) . '">Detalles</a>';
                }
                unset($_SESSION['pasado']);
                echo '</div>';
            }
        }
    ?>
    </div>
    <script src="./js/misEventos.js"></script>
</body>
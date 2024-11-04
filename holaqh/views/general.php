<?php
    /*if (!isset($_SESSION['usuario'])) {
        header('Location: ./sesion.php');
        exit();
    }*/
?>
<head>
    <meta charset="UTF-8">
    <title>Página General</title>
    <link rel="stylesheet" href="./css/general.css">
</head>
<body class="general-body">
    <?php require_once '../views/barra.php' ?>
    <?php
        if (isset($_SESSION['mensaje'])) {
            echo '<div id="mensaje" class="alert alert-danger" role="alert">Mensaje: ' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
        }
        unset($_SESSION['mensaje']);
    ?>
    <ul>
        <?php
            include_once '../conexion.php';
            include_once '../controllers/eventoController.php';

            $controllers = new eventoController($pdo);
            $eventos = $controllers->obtenerEventos();

            foreach ($eventos as $evento) {
                echo '<div class="ficha">';
                echo '<h2>' . htmlspecialchars($evento['titulo']) . '</h2>';
                echo '<p><strong>Descripción: </strong>' . htmlspecialchars($evento['descripcion']) . '.</p>';
                echo '<p><strong>Detalles Adicionales:</strong></p>';
                echo '<ul>';
                echo '<li><i class="fas fa-clock"></i> <strong>Hora:</strong> ' . htmlspecialchars($evento['hora']) . '</li>';
                echo '<li><i class="fas fa-calendar-alt"></i> <strong>Fecha:</strong> ' . htmlspecialchars($evento['fecha']) . '</li>';
                echo '</ul><br>';
                echo '<a href="../servers/eventoServer.php?action=detalleGeneral&no=' . htmlspecialchars($evento['no_evento']) . '" class="button">Detalles</a>';
                echo '</div>';
            }
        ?>
    </ul>
    <script src="./js/general.js"></script>
</body>
<?php
    session_start(); //print_r($_SESSION['anunciantes']);
?>
<head>
    <link rel="stylesheet" href="./css/barra.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="barra-body">
    <div class="navbar">
        <div class="left-items">
            <?php
                if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(1, $_SESSION['rol'])) {
                    echo '<a href="http://localhost/holaqh/views/general.php">Inicio</a>';
                    echo '<a href="http://localhost/holaqh/servers/eventoServer.php?action=mostrar-autorizacion">Publicaciones Pendientes</a>';
                    echo '<a href="http://localhost/holaqh/servers/reporteServer.php?action=reportes">Reportes de Clientes</a>';
                } else if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(2, $_SESSION['rol'])) {
                    echo '<a href="http://localhost/holaqh/servers/eventoServer.php?action=futuros">Mis Eventos</a>';
                    echo '<a href="http://localhost/holaqh/servers/mensajeServer.php?action=mostrar">Mensajes</a>';
                } else if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(3, $_SESSION['rol'])) {
                    echo '<a href="http://localhost/holaqh/views/general.php">Inicio</a>';
                    echo '<a href="http://localhost/holaqh/servers/asistenciaServer.php?action=futuros">Mis Asistencias</a>';
                    echo '<a href="http://localhost/holaqh/servers/mensajeServer.php?action=mostrar">Mensajes</a>';
                } else {
                    echo '<a href="http://localhost/holaqh/views/general.php">Inicio</a>';
                }
            ?>
        </div>
        <div class="dropdown">
            <a href="#" class="dropbtn">Configuración</a>
            <div class="dropdown-content">
            <?php
                if (isset($_SESSION['usuario'])) {
                    if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(1, $_SESSION['rol'])) {
                        echo '<a href="http://localhost/holaqh/views/perfil.php">Crear Administrador</a>';
                    }
                    echo '<a href="http://localhost/holaqh/servers/credencialServer.php?action=perfil">Perfil</a>';
                    echo '<a href="http://localhost/holaqh/views/cerrar.php">Cerrar sesión</a>';
                } else {
                    echo '<a href="http://localhost/holaqh/views/sesion.php">Iniciar Sesión</a>';
                    echo '<a href="http://localhost/holaqh/views/crearConsumidor.php">Crear Cuenta</a>';
                }
            ?>
            </div>
        </div>
    </div>
</body>
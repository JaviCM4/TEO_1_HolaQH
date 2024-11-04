<?php
    session_start(); // Iniciar la sesión
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión

    // Redirigir a la página de login
    header('Location: ../views/general.php'); // Cambia esta ruta si es necesario
    exit();
?>

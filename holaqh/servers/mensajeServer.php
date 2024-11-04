<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/mensajeController.php';

    $controller = new mensajeController($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'];

        switch ($action) {
            case 'mostrar':
                $notificaciones = $controller->obtenerMensajes($_SESSION['usuario']);
                $_SESSION['notificaciones'] = $notificaciones;
                header('Location: ../views/mensajes.php');
                exit();
                break;
            default:
                $error = urlencode("Error.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }      
    }
?>
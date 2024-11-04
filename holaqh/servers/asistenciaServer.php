<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/asistenciaController.php';

    $controller = new asistenciaController($pdo);
    $anunciantes = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'];

        switch ($action) {
            case 'crear':
                $mensaje = $controller->crearAsistencia($_SESSION['usuario'], $_GET['no']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../views/general.php');
                exit();
                break;
            case 'eliminar':
                $mensaje = $controller->eliminarAsistencia($_SESSION['usuario'], $_GET['no']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../views/misEventos.php');
                exit();
                break;
            case 'futuros':
                $eventos = $controller->obtenerMisEventosFuturos($_SESSION['usuario']);
                $_SESSION['eventos'] = $eventos;
                header('Location: ../views/misEventos.php');
                exit();
                break;
            case 'pasados':
                    $eventos = $controller->obtenerMisEventosPasados($_SESSION['usuario']);
                    $_SESSION['eventos'] = $eventos;
                    header('Location: ../views/misEventos.php');
                    exit();
                    break;
            default:
                $error = urlencode("Error.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }      
    }
?>
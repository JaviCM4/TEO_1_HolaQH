<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/reporteController.php';
    include_once '../controllers/eventoController.php';

    $controller = new reporteController($pdo);
    $controllerDos = new eventoController($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

        switch ($action) {
            case 'crear':
                $mensaje = $controller->crearReporte($_SESSION['usuario'], $_POST['no_evento'], $_POST['descripcion']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ../views/general.php');
                exit();
                break;
            default:
                $error = urlencode("Acción no válida.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'];

        switch ($action) {
            case 'mostrar':
                $_SESSION['no'] = $_GET['no'];
                header("Location: ../views/reporte.php");
                exit();
                break;
            case 'reportes':
                $reportes = $controller->obtenerReportes();
                $_SESSION['reportes'] = $reportes;
                header("Location: ../views/reporte.php");
                exit();
                break;
            case 'detalle':
                $reportes = $controller->obtenerReportesEspecificos($_GET['no']);
                $evento = $controllerDos->obtenerDetalleEvento($_GET['no']);
                $_SESSION['reportes_especificos'] = $reportes;
                $_SESSION['evento'] = $evento;
                header("Location: ../views/reporte.php");
                exit();
                break;
            case 'aprobar':
                $mensaje = $controller->aprobarReporte($_GET['no']);
                $_SESSION['mensaje'] = $mensaje;
                header("Location: ./reporteServer.php?action=reportes");
                exit();
                break;
            case 'ignorar':
                $mensaje = $controller->ignorarReporte($_GET['no']);
                $_SESSION['mensaje'] = $mensaje;
                header("Location: ./reporteServer.php?action=reportes");
                exit();
                break;                    
            default:
                $error = urlencode("Acción no válida.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }
    }
?>
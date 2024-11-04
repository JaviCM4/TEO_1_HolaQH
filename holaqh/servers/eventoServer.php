<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/eventoController.php';

    $controller = new eventoController($pdo);
    $anunciantes = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

        switch ($action) {
            case 'crear':
                $mensaje = $controller->crearEvento($_SESSION['usuario'], $_POST['titulo'], $_POST['descripcion'], $_POST['lugar'], $_POST['direccion'], $_POST['edad'], $_POST['capacidad'],  $_POST['hora'],  $_POST['fecha'],  $_POST['medio']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ./eventoServer.php?action=futuros');
                exit();
                break;
            case 'actualizar':
                $mensaje = $controller->actualizarEvento($_POST['no_evento'], $_POST['titulo'], $_POST['descripcion'], $_POST['lugar'], $_POST['direccion'], $_POST['edad'], $_POST['capacidad'],  $_POST['hora'],  $_POST['fecha'],  $_POST['medio']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ./eventoServer.php?action=futuros');
                exit();
                break;
            case 'denegar':
                $mensaje = $controller->denegarPublicacion($_POST['no_evento'], $_POST['descripcion']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ./eventoServer.php?action=mostrar-autorizacion');
                exit();
                break;
            case 'delete':
                $mensaje = $controller->eliminarEvento($_POST['no_evento'], $_POST['descripcion']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ./eventoServer.php?action=futuros');
                exit();
            default:
                $error = urlencode("Acción no válida.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'];

        switch ($action) {
            case 'futuros':
                $eventos = $controller->obtenerMisEventosFuturos($_SESSION['usuario']);
                $_SESSION['eventos'] = $eventos;
                header('Location: ../views/misEventos.php');
                exit();
                break;
            case 'pasados':
                $eventos = $controller->obtenerMisEventosPasados($_SESSION['usuario']);
                $_SESSION['eventos'] = $eventos;
                $_SESSION['pasado'] = true;
                header('Location: ../views/misEventos.php');
                exit();
                break;
            case 'detalleGeneral':
                $detalle = $controller->obtenerDetalleEvento($_GET['no']);
                $_SESSION['detalle'] = $detalle;
                $_SESSION['general'] = true;
                header('Location: ../views/detalleEvento.php');
                exit();
                break;
            case 'detalleAutorizacion':
                $detalle = $controller->obtenerDetalleEvento($_GET['no']);
                $_SESSION['detalle'] = $detalle;
                header('Location: ../views/verificarPublicaciones.php');
                exit();
                break;
            case 'detalle':
                $detalle = $controller->obtenerDetalleEvento($_GET['no']);
                $_SESSION['detalle'] = $detalle;
                header('Location: ../views/detalleEvento.php');
                exit();
                break;
            case 'actualizar':
                $respuesta = $controller->verificarReportesYAprobacion($_GET['no']); 

                if ($respuesta == 1) { 
                    $detalle = $controller->obtenerDetalleEvento($_GET['no']);
                    $_SESSION['detalle'] = $detalle;
                    header('Location: ../views/crearEvento.php');
                    exit();
                } else if ($respuesta == 2) { 
                    $_SESSION['mensaje'] = 'No se puede editar la Publicación, porque tiene Reportes';
                    header('Location: ./eventoServer.php?action=futuros');
                }
                break;
            case 'mostrar-delete':
                $_SESSION['formulario'] = true;
                $_SESSION['no'] = $_GET['no'];
                header('Location: ../views/mensajes.php');
                exit();
            case 'mostrar-autorizacion':
                /*Administración*/
                $autorizaciones = $controller->mostrarAutorizacionesPendientes();
                $_SESSION['autorizaciones'] = $autorizaciones;
                header('Location: ../views/verificarPublicaciones.php');
                exit();
            case 'autorizacion-aprobada':
                /*Administración*/
                $mensaje = $controller->autorizarPublicacion($_GET['no']);
                $_SESSION['mensaje'] = $mensaje;
                header('Location: ./eventoServer.php?action=mostrar-autorizacion');
                exit();
            case 'denegar':
                /*Administración*/
                $_SESSION['no'] = $_GET['no'];
                $_SESSION['formulario'] = true;
                header('Location: ../views/verificarPublicaciones.php');
                exit();
            default:
                $error = urlencode("Error.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }
    }
?>
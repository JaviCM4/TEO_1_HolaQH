<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/credencialController.php';

    $controller = new credencialController($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

        switch ($action) {
            case 'validar':
                $respuesta = $controller->validar($_POST['usuario'], $_POST['clave']);

                if ($respuesta != 4 && $respuesta != 5) {
                    $_SESSION['usuario'] = $_POST['usuario'];
                    $_SESSION['rol'] = $respuesta;

                    if ($_SESSION['rol']['rol'] == 2) {
                        header('Location: ./eventoServer.php?action=futuros');
                        exit();
                    } else {
                        header('Location: ../views/general.php');
                        exit();
                    }
                } else {
                    if ($respuesta == 4) {
                        $error = urlencode("Usuario o Contraseña Incorrectos");
                        header("Location: ../views/sesion.php?error=$error");
                        exit();
                    } else {
                        $error = urlencode("El Usuario esta Baneado");
                        header("Location: ../views/sesion.php?error=$error");
                        exit();
                    }
                }
                break;
            case 'actualizar-uno':
                $mensaje = $controller->actualizarOpcionUno($_SESSION['usuario'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['telefono'], $_POST['clave'], $_SESSION['rol']['rol']);
                $_SESSION['mensaje'] = "Información del Usuario Actualizado";
                header('Location: ../views/general.php');
                exit();
                break;
            case 'actualizar-dos':
                $mensaje = $controller->actualizarOpcionDos($_SESSION['usuario'], $_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['direccion'], $_POST['clave']);
                $_SESSION['mensaje'] = "Información del Usuario Actualizado";
                header('Location: ../views/misEventos.php');
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
            case 'perfil':
                $perfil = $controller->obtenerPerfil($_SESSION['usuario'], $_SESSION['rol']['rol']);
                $_SESSION['perfil'] = $perfil;
                header('Location: ../views/perfil.php');
                exit();
                break;
            default:
                $error = urlencode("Error.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }
    }
?>
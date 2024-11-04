<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/anuncianteController.php';

    $controller = new anuncianteController($pdo);
    $anunciantes = [];
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

        switch ($action) {
            case 'validar':
                $result = $controller->validar($_POST['usuario'], $_POST['clave']);

                if (!empty($result)) {
                    $_SESSION['usuario'] = $_POST['usuario'];
                    header('Location: ../views/general.php');
                    exit();
                } else {
                    $error = urlencode("Usuario o contraseña incorrectos.");
                    header("Location: ../views/sesion.php?error=$error");
                    exit();
                }
                break;
            case 'crear':
                $controller->crearAnunciante($_POST['usuario'], $_POST['nombre'], $_POST['correo'], $_POST['telefono'], $_POST['direccion'], $_POST['clave']);
                header('Location: ../views/general.php');
                exit();
                break;
            default:
                $error = urlencode("Acción no válida.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }
    }
?>
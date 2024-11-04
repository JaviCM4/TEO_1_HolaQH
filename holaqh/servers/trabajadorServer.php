<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/trabajadorController.php';

    $controller = new trabajadorController($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

        switch ($action) {
            case 'crear':
                $controller->crearTrabajador($_POST['usuario'], $_POST['nombres'], $_POST['apellidos'], $_POST['correo'], $_POST['telefono'], $_POST['clave']);
                header('Location: ../views/perfil.php');
                exit();
                break;
            default:
                $error = urlencode("Acción no válida.");
                header("Location: ../views/sesion.php?error=$error");
                exit();
        }
    } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $action = $_GET['action'];
    }
?>
<?php
    session_start();
    include_once '../conexion.php';
    include_once '../controllers/clienteController.php';

    $controller = new clienteController($pdo);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'];

        switch ($action) {
            case 'crear':
                $controller->crearCliente($_POST['usuario'], $_POST['nombres'], $_POST['apellidos'], $_POST['edad'], $_POST['correo'], $_POST['telefono'],  $_POST['clave']);
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
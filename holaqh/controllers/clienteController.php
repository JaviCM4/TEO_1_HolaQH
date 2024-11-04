<?php
    include_once '../conexion.php';
    include_once '../models/clienteModel.php';

    class clienteController {
        private $model;

        public function __construct($pdo) {
            $this->model = new clienteModel($pdo);
        }

        public function crearCliente($usuario, $nombres, $apellidos, $edad, $correo, $telefono, $clave) {
            return $this->model->crearCliente($usuario, $nombres, $apellidos, $edad, $correo, $telefono, $clave);
        }
    }
?>

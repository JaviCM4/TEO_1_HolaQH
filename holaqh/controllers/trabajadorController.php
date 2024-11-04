<?php
    include_once '../conexion.php';
    include_once '../models/trabajadorModel.php';

    class trabajadorController {
        private $model;

        public function __construct($pdo) {
            $this->model = new trabajadorModel($pdo);
        }

        public function crearTrabajador($usuario, $nombres, $apellidos, $correo, $telefono, $clave) {
            return $this->model->crearTrabajador($usuario, $nombres, $apellidos, $correo, $telefono, $clave);
        }
    }
?>

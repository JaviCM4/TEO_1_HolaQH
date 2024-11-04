<?php
    include_once '../conexion.php';
    include_once '../models/anuncianteModel.php';

    class anuncianteController {
        private $model;

        public function __construct($pdo) {
            $this->model = new anuncianteModel($pdo);
        }

        public function validar($usuario, $clave) {
            return $this->model->validar($usuario, $clave);
        }

        public function crearAnunciante($usuario, $nombre, $correo, $telefono, $direccion, $clave) {
            return $this->model->crearAnunciante($usuario, $nombre, $correo, $telefono, $direccion, $clave);
        }
    }
?>

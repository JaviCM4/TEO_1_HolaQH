<?php
    include_once '../conexion.php';
    include_once '../models/mensajeModel.php';

    class mensajeController {
        private $model;

        public function __construct($pdo) {
            $this->model = new mensajeModel($pdo);
        }
    
        public function obtenerMensajes($usuario) {
            return $this->model->obtenerMensajes($usuario);
        }
    }
?>

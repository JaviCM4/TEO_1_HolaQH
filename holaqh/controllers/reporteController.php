<?php
    include_once '../conexion.php';
    include_once '../models/reporteModel.php';

    class reporteController {
        private $model;

        public function __construct($pdo) {
            $this->model = new reporteModel($pdo);
        }

        public function crearReporte($usuario, $no, $descripcion) {
            return $this->model->crearReporte($usuario, $no, $descripcion);
        }

        public function obtenerReportes() {
            return $this->model->obtenerReportes();
        }

        public function obtenerReportesEspecificos($no) {
            return $this->model->obtenerReportesEspecificos($no);
        }

        public function aprobarReporte($no) {
            return $this->model->aprobarReporte($no);
        }

        public function ignorarReporte($no) {
            return $this->model->ignorarReporte($no);
        }
    }
?>

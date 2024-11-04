<?php
    include_once '../conexion.php';
    include_once '../models/eventoModel.php';

    class eventoController {
        private $model;

        public function __construct($pdo) {
            $this->model = new eventoModel($pdo);
        }

        public function crearEvento($usuario, $titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio) {
            return  $this->model->crearEvento($usuario, $titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio);
        }

        public function obtenerMisEventosFuturos($usuario) {
            return $this->model->obtenerMisEventosFuturos($usuario);
        }

        public function obtenerMisEventosPasados($usuario) {
            return $this->model->obtenerMisEventosPasados($usuario);
        }

        public function obtenerDetalleEvento($no_evento) {
            return $this->model->obtenerDetalleEvento($no_evento);
        }

        public function obtenerEventos() {
            return $this->model->obtenerEventos();
        }

        public function verificarReportesYAprobacion($no) {
            return $this->model->verificarReportesYAprobacion($no);
        }

        public function actualizarEvento($no, $titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio) {
            $respuesta = $this->model->actualizarEvento($no, $titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio);
            
            if ($respuesta) {
                return 'Evento Actualizado';
            } else {
                return 'Error al actualizar el Evento, intentelo nuevamente';
            }
        }

        public function eliminarEvento($no, $descripcion) {
            return $this->model->eliminarEvento($no, $descripcion);
        }

        public function mostrarAutorizacionesPendientes() {
            return $this->model->autorizacionesPendientes();
        }

        public function autorizarPublicacion($no) {
            return $this->model->autorizarPublicacion($no);
        }

        public function denegarPublicacion($no, $descripcion) {
            return $this->model->denegarPublicacion($no, $descripcion);
        }
    }
?>

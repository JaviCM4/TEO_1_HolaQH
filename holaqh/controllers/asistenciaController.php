<?php
    include_once '../conexion.php';
    include_once '../models/asistenciaModel.php';

    class asistenciaController {
        private $model;

        public function __construct($pdo) {
            $this->model = new asistenciaModel($pdo);
        }

        public function crearAsistencia($usuario, $no) {
            return $this->model->crearAsistencia($usuario, $no);
        }

        public function eliminarAsistencia($usuario, $no) {
            $respuesta =  $this->model->eliminarAsistencia($usuario, $no);

            if ($respuesta) {
                return 'Se elimino tu asistencia a este Evento';
            } else {
                return 'Error al eliminar asistencia, Intentelo Nuevamente';
            }
        }

        public function obtenerMisEventosFuturos($usuario) {
            return $this->model->obtenerMisEventosFuturos($usuario);
        }

        public function obtenerMisEventosPasados($usuario) {
            return $this->model->obtenerMisEventosPasados($usuario);
        }
    }
?>

<?php
    include_once '../conexion.php';
    include_once '../models/credencialModel.php';
    include_once '../models/trabajadorModel.php';
    include_once '../models/anuncianteModel.php';
    include_once '../models/clienteModel.php';

    class credencialController {
        private $model;
        private $modelTrabajador;
        private $modelAnunciante;
        private $modelCliente;

        public function __construct($pdo) {
            $this->model = new credencialModel($pdo);
            $this->modelTrabajador = new trabajadorModel($pdo);
            $this->modelAnunciante = new anuncianteModel($pdo);
            $this->modelCliente = new clienteModel($pdo);
        }

        public function validar($usuario, $clave) {
            $respuesta = $this->model->validar_general($usuario, $clave);

            if ($respuesta['rol'] == 2) {
                $suspendido = $this->model->validar_anunciante($usuario);

                if ($suspendido['suspendido'] == 1) {
                    return 5;
                }
            }
            return $respuesta;
        }

        public function obtenerPerfil($usuario, $rol) {
            if ($rol == 1) {
                return $this->modelTrabajador->obtenerPerfil($usuario);
            } elseif ($rol == 2) {
                return $this->modelAnunciante->obtenerPerfil($usuario);
            } elseif ($rol == 3) {
                return $this->modelCliente->obtenerPerfil($usuario);
            } else {
                return null;
            }            
        }

        public function actualizarOpcionUno($usuario, $nombres, $apellidos, $correo, $telefono, $clave, $rol) {
            if ($rol == 1) {
                return $this->modelTrabajador->actualizarAdministrador($usuario, $nombres, $apellidos, $correo, $telefono, $clave);
            } elseif ($rol == 3) {
                return $this->modelCliente->actualizarCliente($usuario, $nombres, $apellidos, $correo, $telefono, $clave);
            }
        }

        public function actualizarOpcionDos($usuario, $nombre, $correo, $telefono, $direccion, $clave) {
            return $this->modelAnunciante->actualizarAnunciante($usuario, $nombre, $correo, $telefono, $direccion, $clave);
        }
    }
?>
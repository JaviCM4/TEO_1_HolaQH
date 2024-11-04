<?php
    include_once '../conexion.php';

    class trabajadorModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function crearTrabajador($usuario, $nombres, $apellidos, $correo, $telefono, $clave) {
            $this->agregarCredenciales($usuario, $clave);
            $stmt = $this->pdo->prepare("INSERT INTO administradores(id_administrador, nombres, apellidos, correo, telefono) VALUES (?, ?, ?, ?, ?);");
            return $stmt->execute([$usuario, $nombres, $apellidos, $correo, $telefono]);
        }

        private function agregarCredenciales($usuario, $clave) {
            $stmt = $this->pdo->prepare("INSERT INTO credenciales (id_usuario, clave, rol) VALUES (?, ?, '1');");
            return $stmt->execute([$usuario, $clave]);
        }

        public function obtenerPerfil($usuario) {
            $stmt = $this->pdo->prepare("SELECT * FROM administradores WHERE id_administrador = ?");
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Actualizar
        public function actualizarAdministrador($usuario, $nombres, $apellidos, $correo, $telefono, $clave) {
            if ($clave != null) {
                $this->actualizarCredencial($usuario, $clave);
            }
            $stmt = $this->pdo->prepare("UPDATE administradores SET nombres = ?, apellidos = ?, correo = ?, telefono = ? WHERE id_administrador = ?;");
            return $stmt->execute([$nombres, $apellidos, $correo, $telefono, $usuario]);
        }

        private function actualizarCredencial($usuario, $clave) {
            $stmt = $this->pdo->prepare("UPDATE credenciales SET clave = ? WHERE id_usuario = ?;");
            return $stmt->execute([$clave, $usuario]);
        }
    }
?>

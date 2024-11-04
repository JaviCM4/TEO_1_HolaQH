<?php
    include_once '../conexion.php';

    class anuncianteModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function validar($usuario, $clave) {
            $stmt = $this->pdo->prepare("SELECT * FROM anunciantes WHERE id_anunciante = ? AND clave = ?");
            $stmt->execute([$usuario, $clave]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function crearAnunciante($usuario, $nombre, $correo, $telefono, $direccion, $clave) {
            $this->agregarCredenciales($usuario, $clave);
            $stmt = $this->pdo->prepare("INSERT INTO anunciantes(id_anunciante, nombre, correo, telefono, direccion) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$usuario, $nombre, $correo, $telefono, $direccion]);
        }

        private function agregarCredenciales($usuario, $clave) {
            $stmt = $this->pdo->prepare("INSERT INTO credenciales (id_usuario, clave, rol) VALUES (?, ?, '2');");
            return $stmt->execute([$usuario, $clave]);
        }

        public function obtenerPerfil($usuario) {
            $stmt = $this->pdo->prepare("SELECT * FROM anunciantes WHERE id_anunciante = ?");
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

         // Actualizar
         public function actualizarAnunciante($usuario, $nombre, $correo, $telefono, $direccion, $clave) {
            if ($clave != null) {
                $this->actualizarCredencial($usuario, $clave);
            }
            $stmt = $this->pdo->prepare("UPDATE anunciantes SET nombre = ?, correo = ?, telefono = ?, direccion = ? WHERE id_anunciante = ?;");
            return $stmt->execute([$nombre, $correo, $telefono, $direccion, $usuario]);
        }

        private function actualizarCredencial($usuario, $clave) {
            $stmt = $this->pdo->prepare("UPDATE credenciales SET clave = ? WHERE id_usuario = ?;");
            return $stmt->execute([$clave, $usuario]);
        }
    }
?>
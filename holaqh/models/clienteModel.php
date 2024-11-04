<?php
    include_once '../conexion.php';

    class clienteModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
    
        public function crearCliente($usuario, $nombres, $apellidos, $edad, $correo, $telefono, $clave) {
            $this->agregarCredenciales($usuario, $clave);
            $stmt = $this->pdo->prepare("INSERT INTO clientes (id_cliente, nombres, apellidos, edad, correo, telefono) VALUES (?, ?, ?, ?, ?, ?);");
            return $stmt->execute([$usuario, $nombres, $apellidos, $edad, $correo, $telefono]);
        }

        private function agregarCredenciales($usuario, $clave) {
            $stmt = $this->pdo->prepare("INSERT INTO credenciales (id_usuario, clave, rol) VALUES (?, ?, '3');");
            return $stmt->execute([$usuario, $clave]);
        }

        public function obtenerPerfil($usuario) {
            $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id_cliente = ?");
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        // Actualizar
        public function actualizarCliente($usuario, $nombres, $apellidos, $correo, $telefono, $clave) {
            if ($clave != null) {
                $this->actualizarCredencial($usuario, $clave);
            }
            $stmt = $this->pdo->prepare("UPDATE clientes SET nombres = ?, apellidos = ?, correo = ?, telefono = ? WHERE id_cliente = ?;");
            return $stmt->execute([$nombres, $apellidos, $correo, $telefono, $usuario]);
        }

        private function actualizarCredencial($usuario, $clave) {
            $stmt = $this->pdo->prepare("UPDATE credenciales SET clave = ? WHERE id_usuario = ?;");
            return $stmt->execute([$clave, $usuario]);
        }
    }
?>
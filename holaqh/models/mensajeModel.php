<?php
    include_once '../conexion.php';

    class mensajeModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function obtenerMensajes($usuario) {
            $stmt = $this->pdo->prepare("SELECT * FROM mensajes WHERE id_receptor = ? ORDER BY fecha DESC;");
            $stmt->execute([$usuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>

<?php
    include_once '../conexion.php';

    class credencialModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function validar_general($usuario, $clave) {
            $stmt = $this->pdo->prepare("SELECT rol FROM credenciales WHERE id_usuario = ? AND clave = ?");
            $stmt->execute([$usuario, $clave]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado;
            } else {
                return 4;
            }
        }

        public function validar_anunciante($usuario) {
            $stmt = $this->pdo->prepare("SELECT suspendido FROM anunciantes WHERE id_anunciante = ?");
            $stmt->execute([$usuario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }
?>
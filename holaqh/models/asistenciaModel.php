<?php
    include_once '../conexion.php';

    class asistenciaModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function crearAsistencia($usuario, $no) {
            $stmt = $this->pdo->prepare("SELECT verificar_asistencia_evento(?, ?);");
            $stmt->execute([$usuario, $no]);
            return $stmt->fetchColumn();
        }

        public function eliminarAsistencia($usuario, $no) {
            $stmt = $this->pdo->prepare("DELETE FROM asistencia_eventos WHERE id_cliente = ? AND no_evento = ?;");
            return $stmt->execute([$usuario, $no]);
        }
    
        public function obtenerMisEventosFuturos($usuario) {
            $stmt = $this->pdo->prepare("SELECT 
                                            eventos.no_evento,
                                            eventos.titulo,
                                            eventos.descripcion,
                                            eventos.lugar,
                                            eventos.direccion,
                                            eventos.edad,
                                            eventos.capacidad,
                                            COALESCE(SUM(asistencia_eventos.no_evento), 0) AS asistencia,
                                            eventos.hora,
                                            eventos.fecha,
                                            DATEDIFF(eventos.fecha, CURRENT_DATE) AS faltan,
                                            eventos.medio,
                                            EXISTS (
                                                SELECT 1
                                                FROM reportes_eventos
                                                WHERE reportes_eventos.no_evento = eventos.no_evento
                                            ) AS reportado
                                        FROM 
                                            asistencia_eventos 
                                        JOIN 
                                            eventos ON eventos.no_evento = asistencia_eventos.no_evento
                                        WHERE 
                                            asistencia_eventos.id_cliente = ?
                                            AND eventos.fecha >= CURRENT_DATE
                                        GROUP BY 
                                            eventos.no_evento,
                                            eventos.titulo, 
                                            eventos.descripcion, 
                                            eventos.lugar, 
                                            eventos.direccion, 
                                            eventos.edad, 
                                            eventos.capacidad, 
                                            eventos.hora, 
                                            eventos.fecha, 
                                            eventos.medio
                                        ORDER BY 
                                            faltan ASC;");
            $stmt->execute([$usuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerMisEventosPasados($usuario) {
            $stmt = $this->pdo->prepare("SELECT 
                                            eventos.titulo,
                                            eventos.descripcion,
                                            eventos.lugar,
                                            eventos.direccion,
                                            eventos.edad,
                                            eventos.capacidad,
                                            COALESCE(SUM(asistencia_eventos.no_evento), 0) AS asistencia,
                                            eventos.hora,
                                            eventos.fecha,
                                            eventos.medio
                                        FROM 
                                            eventos 
                                        LEFT JOIN 
                                            asistencia_eventos ON asistencia_eventos.no_evento = eventos.no_evento
                                        WHERE 
                                            eventos.id_anunciante = ?
                                            AND eventos.fecha < CURRENT_DATE
                                        GROUP BY 
                                            eventos.titulo, 
                                            eventos.descripcion, 
                                            eventos.lugar, 
                                            eventos.direccion, 
                                            eventos.edad, 
                                            eventos.capacidad, 
                                            eventos.hora, 
                                            eventos.fecha, 
                                            eventos.medio;");
            $stmt->execute([$usuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>
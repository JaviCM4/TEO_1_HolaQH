<?php
    include_once '../conexion.php';

    class reporteModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }

        public function crearReporte($usuario, $no, $descripcion) {
            $stmt = $this->pdo->prepare("SELECT verificar_reporte_realizado(?, ?, ?);");
            $stmt->execute([$usuario, $no, $descripcion]);
            return $stmt->fetchColumn();
        }

        public function obtenerReportes() {
            $stmt = $this->pdo->query("SELECT 
                                        eventos.titulo,
                                        eventos.id_anunciante AS anunciante,
                                        COUNT(reportes_eventos.no_evento) AS reportes,
                                        reportes_eventos.no_evento
                                    FROM
                                        reportes_eventos
                                    JOIN 
                                        eventos ON eventos.no_evento = reportes_eventos.no_evento
                                    GROUP BY 
                                        eventos.titulo,
                                        eventos.id_anunciante,
                                        reportes_eventos.no_evento
                                    ORDER BY
                                        reportes DESC;");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerReportesEspecificos($no) {
            $stmt = $this->pdo->prepare("SELECT 
                                            reportes_eventos.id_cliente AS cliente,
                                            reportes_eventos.descripcion,
                                            reportes_eventos.fecha
                                        FROM
                                            reportes_eventos
                                        WHERE
                                            reportes_eventos.no_evento = ?;");
            $stmt->execute([$no]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function aprobarReporte($no) {
            $stmt = $this->pdo->prepare("SELECT aprobar_reporte(?);");
            $stmt->execute([$no]);
            return $stmt->fetchColumn();
        }
        
        public function ignorarReporte($no) {
            $stmt = $this->pdo->prepare("SELECT ignorar_reporte(?);");
            $stmt->execute([$no]);
            return $stmt->fetchColumn();
        }
    }
?>
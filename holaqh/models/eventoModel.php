<?php
    include_once '../conexion.php';

    class eventoModel {
        private $pdo;

        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
    
        // INSERT
        public function crearEvento($usuario, $titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio) {
            $stmt = $this->pdo->prepare("SELECT crear_publicacion(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);");
            $stmt->execute([$usuario, $titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio]);
            return $stmt->fetchColumn();
        }

        // SELECT
        public function obtenerMisEventosFuturos($usuario) {
            $stmt = $this->pdo->prepare("SELECT
                                            e.no_evento,
                                            e.titulo,
                                            e.descripcion,
                                            COUNT(a.id_cliente) AS asistencia,
                                            e.hora,
                                            DATEDIFF(e.fecha, CURRENT_DATE) AS faltan,
                                            e.aprobado,
                                            e.bloqueado,
                                            EXISTS (
                                                SELECT 1
                                                FROM reportes_eventos
                                                WHERE reportes_eventos.no_evento = e.no_evento
                                            ) AS reportado
                                        FROM 
                                            eventos e
                                        LEFT JOIN 
                                            asistencia_eventos a ON e.no_evento = a.no_evento
                                        WHERE 
                                            e.id_anunciante = ?
                                        AND 
                                            e.fecha >= CURRENT_DATE
                                        GROUP BY 
                                            e.no_evento,
                                            e.titulo, 
                                            e.descripcion, 
                                            e.hora, 
                                            e.aprobado,
                                            e.bloqueado
                                        ORDER BY 
                                            faltan ASC;
                                        ");
            $stmt->execute([$usuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerMisEventosPasados($usuario) {
            $stmt = $this->pdo->prepare("SELECT 
                                            eventos.no_evento,
                                            eventos.titulo,
                                            eventos.descripcion,
                                            eventos.hora,
                                            eventos.fecha
                                        FROM 
                                            eventos
                                        WHERE 
                                            eventos.id_anunciante = ?
                                            AND eventos.fecha < CURRENT_DATE;");
            $stmt->execute([$usuario]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerEventos() {
            $stmt = $this->pdo->query("SELECT * FROM eventos WHERE fecha >= CURRENT_DATE AND aprobado = 1 AND bloqueado = 0 ORDER BY fecha ASC;");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function obtenerDetalleEvento($no_evento) {
            $stmt = $this->pdo->prepare("SELECT * FROM eventos WHERE no_evento = ?");
            $stmt->execute([$no_evento]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        public function verificarReportesYAprobacion($no_evento) {
            $stmt = $this->pdo->prepare("SELECT verificar_reportes_y_aprobacion_evento(?);");
            $stmt->execute([$no_evento]);
            return $stmt->fetchColumn();
        }

        // UPDATE
        public function actualizarEvento($no, $titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio) {
            $stmt = $this->pdo->prepare("UPDATE eventos SET titulo = ?, descripcion = ?, lugar = ?, direccion = ?, edad = ?, capacidad = ?, hora = ?, fecha = ?, medio = ?, editar = 0 WHERE no_evento = ?;");
            return $stmt->execute([$titulo, $descripcion, $lugar, $direccion, $edad, $capacidad, $hora, $fecha, $medio, $no]);
        }

        // DELETE
        public function eliminarEvento($no, $descripcion) {
            $stmt = $this->pdo->prepare("SELECT eliminar_evento(?, ?) AS resultado;");
            $stmt->execute([$no, $descripcion]);
            return $stmt->fetchColumn();
        }

        // AUTORIZAR
        public function autorizacionesPendientes() {
            $stmt = $this->pdo->query("SELECT 
                                        eventos.no_evento,
                                        eventos.titulo,
                                        eventos.id_anunciante AS anunciante,
                                        eventos.fecha
                                    FROM
                                        eventos
                                    WHERE
                                        aprobado = 0
                                    AND
                                        editar = 0
                                    ORDER BY
                                        fecha ASC;");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function autorizarPublicacion($no) {
            $stmt = $this->pdo->prepare("SELECT autorizar_publicacion(?);");
            $stmt->execute([$no]);
            return $stmt->fetchColumn();
        }

        public function denegarPublicacion($no, $descripcion) {
            $stmt = $this->pdo->prepare("SELECT denegar_publicacion(?, ?);");
            $stmt->execute([$no, $descripcion]);
            return $stmt->fetchColumn();
        }
    }
?>
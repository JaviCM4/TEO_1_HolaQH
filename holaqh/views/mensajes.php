<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensajes</title>
    <link rel="stylesheet" href="./css/mensaje.css">
</head>
<body class="mensaje-body">
    <?php require_once '../views/barra.php' ?>
    
    <?php 
        $formulario = $_SESSION['formulario'] ?? [];
        unset($_SESSION['formulario']);
        
        if (empty($formulario)): ?>     
            <div class="contenedor-principal"> 
                <div class="contenedor-mensajes">
                    <h2>Mensajes</h2>
                    <div id="tab-mensajes" class="tabla-mensajes">
                        <table>
                            <thead>
                                <tr>
                                    <th>Titulo</th>
                                    <th>Descripcion</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $notificaciones = $_SESSION['notificaciones'] ?? [];

                                    if (empty($notificaciones)) {
                                        echo '<h3>No hay Eventos</h3>';
                                    } else {
                                        foreach ($notificaciones as $notificacion) {
                                            echo '<tr>';
                                            echo '<td>' . htmlspecialchars($notificacion['titulo']) . '</td>'; // Cambiado a 'titulo'
                                            echo '<td>' . htmlspecialchars($notificacion['descripcion']) . '</td>';
                                            echo '<td class="columna-fecha">' . htmlspecialchars($notificacion['fecha'] === '0000-00-00' ? 'Fecha no disponible' : $notificacion['fecha']) . '</td>'; // Manejo de fecha
                                            echo '</tr>';
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="contenedor-principal-eliminacion">
                <?php 
                    if (isset($_SESSION['usuario'])) {
                        if (isset($_SESSION['rol']) && is_array($_SESSION['rol']) && in_array(2, $_SESSION['rol'])) {
                            echo '<div class="contenedor-enlaces">';
                            echo '<a id="boton-separacion" class="button" href="../servers/eventoServer.php?action=futuros">Eventos Próximos</a>';
                            echo '<a class="button" href="../servers/eventoServer.php?action=pasados">Eventos Pasados</a>';
                            echo '<div class="contenedor-enlaces-derechos">';
                            echo '<a id="boton-crear" class="button" href="../views/crearEvento.php">Crear Evento</a>';
                            echo '</div>';
                            echo '</div>';
                        } else {
                            echo '<div class="contenedor-enlaces">';
                            echo '<a id="boton-separacion" class="button" href="../servers/asistenciaServer.php?action=futuros">Eventos Próximos</a>';
                            echo '<a class="button" href="../servers/asistenciaServer.php?action=pasados">Eventos Pasados</a>';
                            echo '</div>';
                        }
                    }
                ?>
                <div class="contenedor-form">
                    <div class="form-reporte">
                        <h2>Formulario Eliminación</h2>
                        <form action="../servers/eventoServer.php" method="POST">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="no_evento" value="<?php echo htmlspecialchars($_SESSION['no'] ?? ''); ?>">

                            <label for="descripcion">Escriba un breve comentario del porque se eliminará esta publicación, para notificarlo a los usuarios Confirmados:</label>
                            <textarea class="areaTexto" type="text" name="descripcion" required></textarea>

                            <button id="boton-eliminar" class="button" type="submit">Eliminar Evento</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; 
    ?>
</body>
</html>
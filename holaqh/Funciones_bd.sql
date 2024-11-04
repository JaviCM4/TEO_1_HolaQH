
/* Esta función nos sirve para eliminar el evento, pero antes de eso verifica que la publicación no este reportada
   en caso lo este no permite la eliminación y en caso contrario borra el evento y notifica a las personas que habian
   confirmado sus asistencia que el evento fue eliminado por x motivo. */
DELIMITER //
CREATE FUNCTION eliminar_evento(evento_no INT, mensaje_evento VARCHAR(400))
RETURNS VARCHAR(150)
BEGIN
    DECLARE conteo INT;
    DECLARE nombre_evento VARCHAR(75);

    SELECT COUNT(*) INTO conteo 
    FROM reportes_eventos 
    WHERE no_evento = evento_no;

    SELECT titulo INTO nombre_evento 
    FROM eventos 
    WHERE no_evento = evento_no
    LIMIT 1;

    IF conteo > 0 THEN
        RETURN 'No se puede eliminar el Evento, porque tiene reportes';
    ELSE
        INSERT INTO mensajes(id_receptor, titulo, descripcion)
        SELECT id_cliente, 'Evento Eliminado', CONCAT('El Evento (', nombre_evento, ') fue eliminado por: ', mensaje_evento)
        FROM asistencia_eventos
        WHERE no_evento = evento_no;

		DELETE FROM asistencia_eventos WHERE no_evento = evento_no;
        DELETE FROM eventos WHERE no_evento = evento_no;

        RETURN 'Evento Eliminado';
    END IF;
END 
// DELIMITER ;




/* Esta función es utilizada cuando el cliente quiere marcar sus asistencia a un evento en caso ya lo haga hecho se
   le notificará al usuario.  */
DELIMITER //
CREATE FUNCTION verificar_asistencia_evento(cliente_id VARCHAR(75), evento_no int)
RETURNS VARCHAR(50)
BEGIN
    DECLARE existe BOOLEAN;

    SELECT COUNT(*) INTO existe 
    FROM asistencia_eventos 
    WHERE id_cliente = cliente_id AND no_evento = evento_no;

    IF existe = 0 THEN
    	INSERT INTO asistencia_eventos (id_cliente, no_evento) VALUES (cliente_id, evento_no);
        RETURN 'Asistencia Confirmada';
    ELSE
        RETURN 'Ya confirmaste tú asistencia a este Evento';
    END IF;
END 
// DELIMITER ;




/* Esta función sirve cuando el cliente quiere reportar una publicación, primero verificamos que sea la primera vez
   que dicho cliente hace un reporte hacia dicha publicación en caso contrario no se permite la acción, luego se
   realiza el reporte y se verifica el número de reportes de la página en caso sea igual a 3 se tiene que
   desabilitar la opción de visualizar la publicación.  */
DELIMITER //
CREATE FUNCTION verificar_reporte_realizado(cliente_id VARCHAR(75), evento_no INT, descripcion_reporte VARCHAR(255))
RETURNS VARCHAR(50)
BEGIN
    DECLARE existe INT;
    DECLARE numero_reportes INT;
    DECLARE anunciante_id VARCHAR(75);
    DECLARE nombre_evento VARCHAR(75);

    SELECT COUNT(*) INTO existe 
    FROM reportes_eventos 
    WHERE id_cliente = cliente_id AND no_evento = evento_no;

    SELECT id_anunciante,titulo INTO anunciante_id,nombre_evento 
    FROM eventos 
    WHERE no_evento = evento_no
    LIMIT 1;

    IF existe = 0 THEN

        INSERT INTO reportes_eventos (id_cliente, no_evento, descripcion) 
        VALUES (cliente_id, evento_no, descripcion_reporte);
        
        SELECT COUNT(*) INTO numero_reportes 
        FROM reportes_eventos 
        WHERE no_evento = evento_no;

        IF numero_reportes >= 3 THEN
            INSERT INTO mensajes(id_receptor, titulo, descripcion) 
            VALUES (anunciante_id, 'Publicación Bloqueada', CONCAT('La Publicacion (', nombre_evento, ') fue retirada de la vista general al recibir 3 Reportes, espere la resolución de Administración sobre su caso.'));
            UPDATE eventos SET bloqueado = 1 WHERE no_evento = evento_no;
        END IF;

        RETURN 'Reporte Enviado';
    ELSE
        RETURN 'Ya hiciste un Reporte hacia esta Publicación';
    END IF;
END //
DELIMITER ; 





/* Esta función es utilizada para */
DELIMITER //
CREATE FUNCTION verificar_reportes_y_aprobacion_evento(evento_no int)
RETURNS INT
BEGIN
	DECLARE evento_aprobado INT;
    DECLARE evento_editado INT;
    DECLARE existe INT;

	SELECT aprobado, editar INTO evento_aprobado, evento_editado
    FROM eventos 
    WHERE no_evento = evento_no
    LIMIT 1;

    SELECT COUNT(*) INTO existe 
    FROM reportes_eventos 
    WHERE no_evento = evento_no;

    IF existe = 0 THEN
    	IF evento_aprobado = 1 OR evento_editado = 1 THEN
        	RETURN 1;
        END IF;
    ELSE
        RETURN 2;
    END IF;
END 
// DELIMITER ;





/* Este función se encarga de eliminar el evento que a sido seleccionado y de hacer las notificaciones correspondientes 
   tanto al administrador como al anunciante. */
DELIMITER //

CREATE FUNCTION aprobar_reporte(evento_no INT)
RETURNS VARCHAR(150)
BEGIN
    DECLARE anunciante_id VARCHAR(25);
    DECLARE titulo_evento VARCHAR(75);
    DECLARE publicar_anunciante TINYINT;
    DECLARE total_eventos INT;

    SELECT id_anunciante,titulo INTO anunciante_id,titulo_evento
    FROM eventos 
    WHERE no_evento = evento_no
    LIMIT 1;

    SELECT COUNT(*) INTO total_eventos
    FROM eventos
    WHERE id_anunciante = anunciante_id;
    
    SELECT publicar INTO publicar_anunciante
    FROM anunciantes 
    WHERE id_anunciante = anunciante_id
    LIMIT 1;

    INSERT INTO mensajes(id_receptor, titulo, descripcion)
    SELECT id_cliente, 'Evento Eliminado por Reporte', CONCAT('La Publicación del evento (', titulo_evento, ') ha sido eliminado por infringir normas de la Página.')
    FROM asistencia_eventos
    WHERE no_evento = evento_no;
    
    DELETE FROM reportes_eventos WHERE no_evento = evento_no;
    DELETE FROM asistencia_eventos WHERE no_evento = evento_no;
    DELETE FROM eventos WHERE no_evento = evento_no;

    IF publicar_anunciante = 1 THEN
    	UPDATE anunciantes SET publicar = 0, aprobados = 0 WHERE id_anunciante = anunciante_id;
        INSERT INTO mensajes(id_receptor, titulo, descripcion) VALUES (anunciante_id, 'Retiro de Publicación Automatica', 'Debido a reportes recibidos en sus publicaciones recientes se le retiro el permiso de publicación automatica, debe acumular 2 publicaciones aprobadas para volver a obtener el beneficio.');
        RETURN 'Publicación Eliminada y mensaje de "Retiro de Publicación Automatica" enviado al Anunciante';
    ELSE
        IF total_eventos <= 2 THEN
            UPDATE anunciantes SET suspendido = 1 WHERE id_anunciante = anunciante_id;
            RETURN 'Publicación Eliminada y Anunciante Baneado';
        ELSE
            RETURN 'Publicación Eliminada, por favor verifique las publicaciones que son Aprobadas';
        END IF;
    END IF;
END 
// DELIMITER ;




/* Esta Función es utilizada para poder ignorar los reportes que tenga una publicación y liberarla en caso este 
   bloqueada o desmarcarla en caso tenga una advertencia. */
DELIMITER //
CREATE FUNCTION ignorar_reporte(evento_no INT)
RETURNS VARCHAR(150)
BEGIN
    DECLARE anunciante_id VARCHAR(25);
    DECLARE titulo_evento VARCHAR(75);

    SELECT id_anunciante,titulo INTO anunciante_id,titulo_evento
    FROM eventos 
    WHERE no_evento = evento_no
    LIMIT 1;
    
    DELETE FROM reportes_eventos WHERE no_evento = evento_no;
    UPDATE eventos SET bloqueado = 0 WHERE no_evento = evento_no;
    INSERT INTO mensajes(id_receptor, titulo, descripcion) VALUES (anunciante_id, 'Retiro de Bloqueos', 
    CONCAT('La publicación (', titulo_evento ,') oficialmente ha sido liberada de los reportes que tenia.'));
    RETURN 'La Publicación ha sido Liberada de los Reportes';
END 
// DELIMITER ;




/* Esta Función es utilida para validar la publicación de un anunciante y ponerlo a la vista publica al realizarlo, 
   se le notifica al usuario que su solicitud publicación ha sido exitosa, en caso sea la tercera publicación aprobada
   se le notificara que ya puede publicar de manera automatica. */
DELIMITER //
CREATE FUNCTION autorizar_publicacion(evento_no INT)
RETURNS VARCHAR(150)
BEGIN
    DECLARE anunciante_id VARCHAR(25);
    DECLARE titulo_evento VARCHAR(75);
    DECLARE editado_evento VARCHAR(75);

    SELECT id_anunciante,titulo,editar INTO anunciante_id,titulo_evento,editado_evento
    FROM eventos 
    WHERE no_evento = evento_no
    LIMIT 1;

    IF editado_evento = 0 THEN
        UPDATE anunciantes SET aprobados = aprobados + 1 WHERE id_anunciante = anunciante_id;
        UPDATE eventos SET aprobado = 1 WHERE no_evento = evento_no;
    ELSE
        UPDATE eventos SET aprobado = 1, editar = 0 WHERE no_evento = evento_no;
    END IF;
    
    INSERT INTO mensajes(id_receptor, titulo, descripcion) 
    VALUES (anunciante_id, 'Publicación Autorizada', 
    CONCAT('La publicación (', titulo_evento, ') ha sido autorizada por administración.'));

    RETURN 'Publicación Autorizada, se notificará al Anunciante';
END
// DELIMITER ;




/* Esta Función es utilida para crear publicaciones. */
DELIMITER //
CREATE FUNCTION crear_publicacion(
    anunciante_id VARCHAR(75), 
    titulo_nuevo VARCHAR(75), 
    descripcion_nuevo VARCHAR(250), 
    lugar_nuevo VARCHAR(75), 
    direccion_nuevo VARCHAR(75), 
    edad_nuevo INT, 
    capacidad_nuevo INT, 
    hora_nuevo TIME,
    fecha_nuevo DATE, 
    medio_nuevo VARCHAR(300)
) 
RETURNS VARCHAR(150)
BEGIN
    DECLARE publicar_anunciante TINYINT;
    DECLARE aprobados_anunciante INT;
    DECLARE total_eventos_no_aprobados INT;

    SELECT publicar, aprobados INTO publicar_anunciante, aprobados_anunciante
    FROM anunciantes 
    WHERE id_anunciante = anunciante_id
    LIMIT 1;

    SELECT COUNT(*) INTO total_eventos_no_aprobados
    FROM eventos
    WHERE aprobado = 0 AND id_anunciante = anunciante_id;

    IF publicar_anunciante = 1 THEN
        INSERT INTO eventos (id_anunciante, titulo, descripcion, lugar, direccion, edad, capacidad, hora, fecha, medio)
        VALUES (anunciante_id, titulo_nuevo, descripcion_nuevo, lugar_nuevo, direccion_nuevo, edad_nuevo, capacidad_nuevo, hora_nuevo, fecha_nuevo, medio_nuevo);
        RETURN 'Publicación creada Exitosamente';
    ELSE
        IF aprobados_anunciante >= 2 THEN
            UPDATE anunciantes SET publicar = 1 WHERE id_anunciante = anunciante_id;
            INSERT INTO eventos (id_anunciante, titulo, descripcion, lugar, direccion, edad, capacidad, hora, fecha, medio)
            VALUES (anunciante_id, titulo_nuevo, descripcion_nuevo, lugar_nuevo, direccion_nuevo, edad_nuevo, capacidad_nuevo, hora_nuevo, fecha_nuevo, medio_nuevo);
            RETURN 'Publicación creada Exitosamente, desde ahora obtienes el beneficio de Publicación Automatica';
        ELSE
            /* IF aprobados_anunciante = 0 AND total_eventos_no_aprobados = 0 THEN */
            IF total_eventos_no_aprobados = 0 THEN
                INSERT INTO eventos (id_anunciante, titulo, descripcion, lugar, direccion, edad, capacidad, hora, fecha, medio)
                VALUES (anunciante_id, titulo_nuevo, descripcion_nuevo, lugar_nuevo, direccion_nuevo, edad_nuevo, capacidad_nuevo, hora_nuevo, fecha_nuevo, medio_nuevo);
                RETURN 'Publicación creada Exitosamente, espere la aprobación de Administración para que sea Visible para Todos';
            ELSE
                RETURN 'Debe esperar a que su Publicación anterior sea Aprobada para poder Crear una Nueva.';
            END IF;
        END IF;
    END IF;

    RETURN 'Error al Crear la Publicación.';
END 
// DELIMITER ;



/* Esta Función es utilida cuando no se aprueba una publiación y se le habilita al usuario para que pueda realizar 
   las restructuracciones necesarias para poder aprobar su publicación. */
DELIMITER //
CREATE FUNCTION denegar_publicacion(evento_no INT, descripcion_nuevo VARCHAR(300))
RETURNS VARCHAR(200)
BEGIN
    DECLARE anunciante_id VARCHAR(25);
    DECLARE titulo_evento VARCHAR(75);

    SELECT id_anunciante, titulo INTO anunciante_id, titulo_evento
    FROM eventos 
    WHERE no_evento = evento_no
    LIMIT 1;
    
    UPDATE eventos SET editar = 1 WHERE no_evento = evento_no;
    
    INSERT INTO mensajes(id_receptor, titulo, descripcion) 
    VALUES (anunciante_id, 'Publicación Denegada', CONCAT('La publicación (', titulo_evento ,') ha sido denegada por la Administración debido a que: (', descripcion_nuevo ,') se le ha habilitado los derechos de edición para que haga los cambios necesarios para que sea aprobada su publicación.'));

    RETURN 'Publicación Denegada, se notificará al Anunciante';
END
// DELIMITER ;

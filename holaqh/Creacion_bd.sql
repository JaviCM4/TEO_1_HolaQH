/* Creación de Tablas */
CREATE TABLE `bd_holaqh`.`credenciales` (`id_usuario` VARCHAR(75) NOT NULL , `clave` VARCHAR(75) NOT NULL , `rol` INT(1) NOT NULL ) ENGINE = InnoDB;

CREATE TABLE `bd_holaqh`.`anunciantes` (`id_anunciante` VARCHAR(75) NOT NULL , `nombre` VARCHAR(75) NOT NULL , `correo` VARCHAR(100) NOT NULL , `telefono` INT(8) NOT NULL , `direccion` VARCHAR(250) NOT NULL , `aprobados` INT(1) NOT NULL , `publicar` TINYINT(1) NOT NULL , `suspendido` TINYINT(1) NOT NULL , PRIMARY KEY (`id_anunciante`)) ENGINE = InnoDB;

CREATE TABLE `bd_holaqh`.`clientes` (`id_cliente` VARCHAR(75) NOT NULL , `nombres` VARCHAR(75) NOT NULL , `apellidos` VARCHAR(75) NOT NULL , `edad` INT(1) NOT NULL , `correo` VARCHAR(100) NOT NULL , `telefono` INT(8) NOT NULL , PRIMARY KEY (`id_cliente`)) ENGINE = InnoDB;

CREATE TABLE `bd_holaqh`.`eventos` (`no_evento` INT(4) NOT NULL AUTO_INCREMENT , `id_anunciante` VARCHAR(75) NOT NULL , `titulo` VARCHAR(75) NOT NULL , `descripcion` VARCHAR(500) NOT NULL , `lugar` VARCHAR(150) NOT NULL , `direccion` VARCHAR(150) NOT NULL , `edad` INT(1) NOT NULL , `capacidad` INT(5) NOT NULL , `hora` TIME NOT NULL , `fecha` DATE NOT NULL , `medio` VARCHAR(300) NOT NULL , `aprobado` TINYINT(1) NOT NULL , `editar` TINYINT(1) NOT NULL , `bloqueado` TINYINT(1) NOT NULL , PRIMARY KEY (`no_evento`)) ENGINE = InnoDB;

CREATE TABLE `bd_holaqh`.`asistencia_eventos` (`no_asistencia` INT(5) NOT NULL AUTO_INCREMENT , `id_cliente` VARCHAR(75) NOT NULL , `no_evento` INT(4) NOT NULL , PRIMARY KEY (`no_asistencia`)) ENGINE = InnoDB;

CREATE TABLE `bd_holaqh`.`mensajes` (`no_mensaje` INT(5) NOT NULL AUTO_INCREMENT , `id_receptor` VARCHAR(75) NOT NULL , `titulo` VARCHAR(75) NOT NULL , `descripcion` VARCHAR(500) NOT NULL , `fecha` DATE NOT NULL , PRIMARY KEY (`no_mensaje`)) ENGINE = InnoDB;

CREATE TABLE `bd_holaqh`.`reportes_eventos` (`no_reporte` INT(5) NOT NULL AUTO_INCREMENT , `id_cliente` VARCHAR(75) NOT NULL , `no_evento` INT(5) NOT NULL , `descripcion` VARCHAR(500) NOT NULL , `fecha` DATE NOT NULL , PRIMARY KEY (`no_reporte`)) ENGINE = InnoDB;

CREATE TABLE `bd_holaqh`.`administradores` (`id_administrador` VARCHAR(75) NOT NULL , `nombres` VARCHAR(75) NOT NULL , `apellidos` VARCHAR(75) NOT NULL , `correo` VARCHAR(100) NOT NULL , `telefono` INT(8) NOT NULL , PRIMARY KEY (`id_administrador`)) ENGINE = InnoDB;

/* Establecer valor Prederminado para la Fecha */
ALTER TABLE mensajes 
MODIFY fecha DATE DEFAULT CURRENT_DATE;

ALTER TABLE reportes_eventos 
MODIFY fecha DATE DEFAULT CURRENT_DATE;



/* Llaves Foraneas */
ALTER TABLE `clientes` ADD FOREIGN KEY (`id_cliente`) REFERENCES `credenciales`(`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `anunciantes` ADD FOREIGN KEY (`id_anunciante`) REFERENCES `credenciales`(`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `asistencia_eventos` ADD FOREIGN KEY (`id_cliente`) REFERENCES `credenciales`(`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `asistencia_eventos` ADD FOREIGN KEY (`no_evento`) REFERENCES `eventos`(`no_evento`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `reportes_eventos` ADD FOREIGN KEY (`id_cliente`) REFERENCES `credenciales`(`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `reportes_eventos` ADD FOREIGN KEY (`no_evento`) REFERENCES `eventos`(`no_evento`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `mensajes` ADD FOREIGN KEY (`id_receptor`) REFERENCES `credenciales`(`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `eventos` ADD FOREIGN KEY (`id_anunciante`) REFERENCES `anunciantes`(`id_anunciante`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `administradores` ADD FOREIGN KEY (`id_administrador`) REFERENCES `credenciales`(`id_usuario`) ON DELETE RESTRICT ON UPDATE RESTRICT;


/* Declaración de TRIGGER que sirve para establecer si una publicación es vista de manera automatica o tiene que
   ser aprobado por administración. */
DELIMITER //

CREATE TRIGGER verificar_publicacion_automatica
BEFORE INSERT ON eventos
FOR EACH ROW
BEGIN
    DECLARE puede_publicar TINYINT(1);
    
    SELECT publicar INTO puede_publicar
    FROM anunciantes
    WHERE id_anunciante = NEW.id_anunciante;
    
    IF puede_publicar IS NULL THEN
        SET NEW.aprobado = FALSE;
    ELSE
        SET NEW.aprobado = puede_publicar;
    END IF;
END;
//

DELIMITER ;

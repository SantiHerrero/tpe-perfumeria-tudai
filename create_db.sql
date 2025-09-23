CREATE TABLE `usuarios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre_usuario` VARCHAR(100),
    `nombre` VARCHAR(50),
    `apellido` VARCHAR(50),
    `tipo` SMALLINT,
    `contrasenia` VARCHAR(255),
    PRIMARY KEY(`id`)
);

CREATE TABLE `laboratorios` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nombre` VARCHAR(50) NOT NULL,
    `descripcion` VARCHAR(512),
    `url` VARCHAR(255) NOT NULL,
    `fundador` VARCHAR(255) NOT NULL,
    `pais` VARCHAR(50) NOT NULL,
    PRIMARY KEY(`id`)
);

CREATE TABLE `perfumes` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `id_laboratorio` INT NOT NULL,
    `precio` DECIMAL(10,2) NOT NULL,
    `codigo` VARCHAR(50),
    `duracion` INT NOT NULL,
    `aroma` VARCHAR(255),
    `sexo` SMALLINT NOT NULL,
    PRIMARY KEY(`id`),
    FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorios`(`id`)
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
);
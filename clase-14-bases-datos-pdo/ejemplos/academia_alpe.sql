-- Base de datos de prácticas de la clase 14.
-- Ejecutadla en HeidiSQL (botón «Base de datos» de Laragon): pestaña Consulta y tecla F9.
-- ¡Ojo! Si la volvéis a ejecutar, la base de datos vuelve a su estado inicial.

SET NAMES utf8mb4;   -- las tildes y eñes del script, en UTF-8

DROP DATABASE IF EXISTS academia_alpe;

CREATE DATABASE academia_alpe
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE academia_alpe;

CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(120) NOT NULL,
    horas INT NOT NULL,
    precio DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    plazas INT NOT NULL DEFAULT 20          -- plazas libres que quedan
) ENGINE=InnoDB;

CREATE TABLE alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,     -- no puede haber dos alumnos con el mismo email
    ciudad VARCHAR(60) NOT NULL DEFAULT 'Santander',
    nota DECIMAL(4,2) NULL,
    curso_id INT NOT NULL,
    fecha_alta DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_alumno_curso FOREIGN KEY (curso_id) REFERENCES cursos(id)
) ENGINE=InnoDB;

INSERT INTO cursos (titulo, horas, precio, plazas) VALUES
    ('PHP 8 desde cero', 80, 250.00, 5),
    ('JavaScript', 60, 180.00, 4),
    ('Bases de datos con MySQL', 40, 120.00, 0),
    ('Laravel', 100, 320.00, 3);

INSERT INTO alumnos (nombre, email, ciudad, nota, curso_id) VALUES
    ('Marta García', 'marta@ejemplo.com', 'Santander', 8.50, 1),
    ('Luis Pérez', 'luis@ejemplo.com', 'Torrelavega', 6.00, 1),
    ('Ana Ruiz', 'ana@ejemplo.com', 'Laredo', 9.25, 2),
    ('Pedro Gómez', 'pedro@ejemplo.com', 'Santander', 4.75, 2),
    ('Sara López', 'sara@ejemplo.com', 'Castro Urdiales', 7.00, 3),
    ('Carlos Díaz', 'carlos@ejemplo.com', 'Santander', NULL, 3),
    ('Lucía Fernández', 'lucia@ejemplo.com', 'Reinosa', 5.50, 4),
    ('Jorge Martín', 'jorge@ejemplo.com', 'Santander', 3.80, 4);

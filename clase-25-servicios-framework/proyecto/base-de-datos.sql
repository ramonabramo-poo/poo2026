-- Base de datos del proyecto CRUD de la clase 15.
-- Ejecutadla en HeidiSQL (botón «Base de datos» de Laragon): pestaña Consulta y tecla F9.
-- ¡Ojo! Si la volvéis a ejecutar, la base de datos vuelve a su estado inicial.

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS academia_crud;

CREATE DATABASE academia_crud
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE academia_crud;

CREATE TABLE cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(120) NOT NULL,
    horas INT NOT NULL,
    precio DECIMAL(8,2) NOT NULL DEFAULT 0.00,
    plazas INT NOT NULL DEFAULT 20
) ENGINE=InnoDB;

CREATE TABLE alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    curso_id INT NOT NULL,
    CONSTRAINT fk_alumno_curso FOREIGN KEY (curso_id) REFERENCES cursos(id)
) ENGINE=InnoDB;

-- Usuarios que pueden gestionar el catálogo. La contraseña NUNCA se guarda tal cual: guardamos su hash.
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    clave_hash VARCHAR(255) NOT NULL,
    creado DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO cursos (titulo, horas, precio, plazas) VALUES
    ('PHP 8 desde cero', 80, 250.00, 5),
    ('JavaScript', 60, 180.00, 4),
    ('Bases de datos con MySQL', 40, 120.00, 0),
    ('Laravel', 100, 320.00, 3),
    ('HTML y CSS', 50, 150.00, 12),
    ('Git y GitHub', 20, 60.00, 15),
    ('Diseño web con Figma', 30, 90.00, 8),
    ('Python para principiantes', 70, 210.00, 10),
    ('Linux para desarrolladores', 35, 100.00, 6),
    ('Docker', 25, 95.00, 9),
    ('Seguridad web', 30, 140.00, 7),
    ('APIs REST', 40, 160.00, 11);

INSERT INTO alumnos (nombre, email, curso_id) VALUES
    ('Marta García', 'marta@ejemplo.com', 1),
    ('Luis Pérez', 'luis@ejemplo.com', 1),
    ('Ana Ruiz', 'ana@ejemplo.com', 2),
    ('Sara López', 'sara@ejemplo.com', 3);

-- Usuario de prueba: admin@academia.test / secreto123
INSERT INTO usuarios (nombre, email, clave_hash) VALUES
    ('Administración', 'admin@academia.test', '$2y$10$oKBna769JDqdzRIByhEF.OnULo0vzsfkeK8jrWEFnF7mfYsCFnuvK');

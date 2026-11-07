-- Ejecutad este SQL en HeidiSQL (botón "Base de datos" de Laragon), pestaña Consulta, tecla F9
CREATE DATABASE academia
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE academia;

CREATE TABLE alumnos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(80) NOT NULL,
    email VARCHAR(120) NOT NULL,
    nota DECIMAL(4,2)
);

INSERT INTO alumnos (nombre, email, nota) VALUES
    ('Marta', 'marta@ejemplo.com', 8.50),
    ('Luis', 'luis@ejemplo.com', 6.00);

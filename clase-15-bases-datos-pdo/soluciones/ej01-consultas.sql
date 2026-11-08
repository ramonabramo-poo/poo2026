-- Ejecutad estas consultas en HeidiSQL, una a una (seleccionadla y pulsad Ctrl + F9)
SET NAMES utf8mb4;
USE academia_alpe;

-- 1. Alumnos de Santander, ordenados por nombre
SELECT nombre, email FROM alumnos
WHERE ciudad = 'Santander'
ORDER BY nombre;

-- 2. Un curso nuevo y un alumno en él
INSERT INTO cursos (titulo, horas, precio, plazas) VALUES ('Git y GitHub', 20, 60.00, 10);
INSERT INTO alumnos (nombre, email, ciudad, curso_id) VALUES ('Elena Torres', 'elena@ejemplo.com', 'Santoña', 5);

-- 3. Nombre, email y curso de cada alumno (INNER JOIN)
SELECT a.nombre, a.email, c.titulo AS curso
FROM alumnos a
INNER JOIN cursos c ON a.curso_id = c.id
ORDER BY c.titulo, a.nombre;

-- 4. La clave foránea en acción: el curso 999 no existe, así que MySQL lo rechaza
--    (error 1452: Cannot add or update a child row: a foreign key constraint fails)
INSERT INTO alumnos (nombre, email, curso_id) VALUES ('Fantasma', 'fantasma@ejemplo.com', 999);

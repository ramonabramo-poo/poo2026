<?php
// Otros tipos de campos: radio, casillas, desplegable y área de texto
$enviado = isset($_POST["enviar"]);

$nivel = $_POST["nivel"] ?? "";              // radio: un solo valor (o nada)
$temas = $_POST["temas"] ?? [];              // casillas con name="temas[]": un ARRAY
$horario = $_POST["horario"] ?? "mañana";    // select: el value de la opción elegida
$comentario = trim($_POST["comentario"] ?? "");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Encuesta</title>
</head>
<body>
    <h1>Encuesta del curso</h1>

    <?php if ($enviado): ?>
        <h2>Tus respuestas</h2>
        <p>Nivel: <?php echo $nivel !== "" ? htmlspecialchars($nivel) : "sin contestar"; ?></p>
        <p>Temas que te interesan:
            <?php echo count($temas) > 0 ? htmlspecialchars(implode(", ", $temas)) : "ninguno"; ?>
        </p>
        <p>Horario: <?php echo htmlspecialchars($horario); ?></p>
        <p>Comentario: <?php echo nl2br(htmlspecialchars($comentario)); ?></p>
        <hr>
    <?php endif; ?>

    <form method="post">
        <p>Tu nivel de PHP:</p>
        <label><input type="radio" name="nivel" value="principiante"> Principiante</label>
        <label><input type="radio" name="nivel" value="intermedio"> Intermedio</label>
        <label><input type="radio" name="nivel" value="avanzado"> Avanzado</label>

        <p>¿Qué temas te interesan?</p>
        <label><input type="checkbox" name="temas[]" value="formularios"> Formularios</label>
        <label><input type="checkbox" name="temas[]" value="bases de datos"> Bases de datos</label>
        <label><input type="checkbox" name="temas[]" value="POO"> POO</label>

        <p>
            Horario preferido:
            <select name="horario">
                <option value="mañana">Mañana</option>
                <option value="tarde">Tarde</option>
                <option value="online">Online</option>
            </select>
        </p>

        <p>Comentario:<br>
            <textarea name="comentario" rows="4" cols="40"></textarea>
        </p>

        <button type="submit" name="enviar">Enviar la encuesta</button>
    </form>
</body>
</html>

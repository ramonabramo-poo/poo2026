<h1>📝 Crear cuenta</h1>

<form method="post" action="/registro" class="formulario">
    <?= campoCsrf() ?>
    <label>Nombre <input name="nombre" value="<?= e(viejo("nombre")) ?>"></label>
    <small class="error"><?= e(error("nombre")) ?></small>
    <label>Email <input type="email" name="email" value="<?= e(viejo("email")) ?>"></label>
    <small class="error"><?= e(error("email")) ?></small>
    <label>Contraseña <input type="password" name="clave"></label>
    <small class="error"><?= e(error("clave")) ?></small>
    <label>Repite la contraseña <input type="password" name="clave2"></label>
    <small class="error"><?= e(error("clave2")) ?></small>
    <p><button class="boton">Crear cuenta</button></p>
</form>

<h1>🔐 Iniciar sesión</h1>

<form method="post" action="/login" class="formulario">
    <?= campoCsrf() ?>
    <label>Email <input type="email" name="email" value="<?= e(viejo("email")) ?>"></label>
    <small class="error"><?= e(error("email")) ?></small>
    <label>Contraseña <input type="password" name="clave"></label>
    <small class="error"><?= e(error("clave")) ?></small>
    <p><button class="boton">Entrar</button></p>
    <p><small>Usuario de prueba: admin@academia.test / secreto123</small></p>
</form>

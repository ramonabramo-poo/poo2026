<h1>✏️ Editar curso</h1>
<?= parcial("cursos/_formulario", ["curso" => $curso, "errores" => $errores, "accion" => "/cursos/{$curso->id}"]) ?>

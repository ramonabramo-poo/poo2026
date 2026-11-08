<?php
declare(strict_types=1);

abstract class Componente
{
    public function __construct(protected string $texto)
    {
    }

    // Las hijas solo deciden su contenido…
    abstract protected function contenido(): string;

    // …pero el envoltorio es siempre igual y nadie lo puede cambiar
    final public function html(): string
    {
        return '<div class="componente">' . $this->contenido() . "</div>";
    }

    protected function e(string $texto): string
    {
        return htmlspecialchars($texto, ENT_QUOTES, "UTF-8");
    }
}

class Boton extends Componente
{
    public function __construct(string $texto, private string $enlace)
    {
        parent::__construct($texto);
    }

    protected function contenido(): string
    {
        return '<a class="boton" href="' . $this->e($this->enlace) . '">' . $this->e($this->texto) . "</a>";
    }
}

class Alerta extends Componente
{
    protected function contenido(): string
    {
        return '<p class="alerta">⚠️ ' . $this->e($this->texto) . "</p>";
    }
}

$componentes = [new Alerta("Quedan 3 plazas"), new Boton("Matricularme", "/matricula")];

foreach ($componentes as $componente) {
    echo $componente->html() . "\n";
}

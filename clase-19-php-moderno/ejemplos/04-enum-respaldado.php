<?php
declare(strict_types=1);

// Enum RESPALDADO (backed): cada caso tiene un valor, aquí un string,
// que es lo que guardaríamos en la base de datos
enum EstadoPedido: string
{
    case PENDIENTE = "pendiente";
    case ENVIADO = "enviado";
    case ENTREGADO = "entregado";
    case CANCELADO = "cancelado";

    // Los enums pueden tener métodos
    public function etiqueta(): string
    {
        return match ($this) {
            EstadoPedido::PENDIENTE => "⏳ Pendiente de envío",
            EstadoPedido::ENVIADO => "🚚 En camino",
            EstadoPedido::ENTREGADO => "✅ Entregado",
            EstadoPedido::CANCELADO => "❌ Cancelado",
        };
    }

    public function estaCerrado(): bool
    {
        return $this === EstadoPedido::ENTREGADO || $this === EstadoPedido::CANCELADO;
    }
}

$estado = EstadoPedido::ENVIADO;

echo "name: {$estado->name}<br>";          // ENVIADO   → el nombre del caso
echo "value: {$estado->value}<br>";        // enviado   → el valor para guardar
echo "{$estado->etiqueta()}<br>";

// Del texto que viene de la base de datos (o de un formulario) al enum
$deLaBaseDeDatos = "entregado";
$estado2 = EstadoPedido::from($deLaBaseDeDatos);
echo "{$estado2->etiqueta()} · ¿cerrado? " . ($estado2->estaCerrado() ? "sí" : "no") . "<br>";

// tryFrom() devuelve null si el texto no es válido (from() lanzaría un error)
$deUnFormulario = "perdido";
$estado3 = EstadoPedido::tryFrom($deUnFormulario);
echo $estado3 === null ? "«{$deUnFormulario}» no es un estado válido<br>" : $estado3->etiqueta();

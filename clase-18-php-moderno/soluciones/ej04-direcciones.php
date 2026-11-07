<?php
declare(strict_types=1);

class Direccion
{
    public function __construct(
        public string $calle,
        public string $ciudad,
        public ?string $codigoPostal = null,
    ) {
    }
}

class Cliente
{
    public function __construct(
        public string $nombre,
        private ?Direccion $direccion = null,
        private ?string $telefono = null,
    ) {
    }

    public function getDireccion(): ?Direccion
    {
        return $this->direccion;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }
}

$clientes = [
    new Cliente("Marta", new Direccion("C/ Burgos 12", "Santander", "39008"), "612345678"),
    new Cliente("Luis", new Direccion("Avda. de España 3", "Torrelavega")),
    new Cliente("Ana"),
];
?>
<table border="1" cellpadding="6">
    <tr><th>Cliente</th><th>Ciudad</th><th>Código postal</th><th>Teléfono</th></tr>
    <?php foreach ($clientes as $cliente): ?>
        <tr>
            <td><?= htmlspecialchars($cliente->nombre) ?></td>
            <td><?= htmlspecialchars($cliente->getDireccion()?->ciudad ?? "—") ?></td>
            <td><?= htmlspecialchars($cliente->getDireccion()?->codigoPostal ?? "—") ?></td>
            <td><?= htmlspecialchars($cliente->getTelefono() ?? "sin teléfono") ?></td>
        </tr>
    <?php endforeach; ?>
</table>

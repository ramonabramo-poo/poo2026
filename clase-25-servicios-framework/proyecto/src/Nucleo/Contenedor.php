<?php
declare(strict_types=1);

namespace App\Nucleo;

use ReflectionClass;
use ReflectionNamedType;

// El CONTENEDOR DE DEPENDENCIAS: sabe cómo fabricar cada objeto y le da lo que necesita
class Contenedor
{
    private array $fabricas = [];      // id => función que fabrica el objeto
    private array $compartidos = [];   // ids que solo se fabrican UNA vez
    private array $instancias = [];    // los objetos compartidos ya fabricados

    // Cada vez que se pida, se fabrica uno nuevo
    public function registrar(string $id, callable $fabrica): void
    {
        $this->fabricas[$id] = $fabrica;
    }

    // Se fabrica la primera vez y después se devuelve siempre el MISMO objeto
    public function compartido(string $id, callable $fabrica): void
    {
        $this->fabricas[$id] = $fabrica;
        $this->compartidos[$id] = true;
    }

    public function obtener(string $id): mixed
    {
        if (isset($this->instancias[$id])) {
            return $this->instancias[$id];
        }

        $objeto = isset($this->fabricas[$id])
            ? ($this->fabricas[$id])($this)
            : $this->construir($id);              // sin receta: lo intentamos solos

        if (isset($this->compartidos[$id])) {
            $this->instancias[$id] = $objeto;
        }
        return $objeto;
    }

    // AUTOWIRING: miramos qué pide el constructor y se lo damos, recursivamente
    private function construir(string $clase): object
    {
        if (!class_exists($clase)) {
            throw new \RuntimeException("El contenedor no sabe crear «{$clase}».");
        }

        $reflexion = new ReflectionClass($clase);
        $constructor = $reflexion->getConstructor();
        if ($constructor === null) {
            return new $clase();
        }

        $argumentos = [];
        foreach ($constructor->getParameters() as $parametro) {
            $tipo = $parametro->getType();
            if ($tipo instanceof ReflectionNamedType && !$tipo->isBuiltin()) {
                $argumentos[] = $this->obtener($tipo->getName());   // una clase: la pedimos al contenedor
            } elseif ($parametro->isDefaultValueAvailable()) {
                $argumentos[] = $parametro->getDefaultValue();
            } else {
                throw new \RuntimeException("No sé qué pasar a \${$parametro->getName()} al crear {$clase}.");
            }
        }
        return $reflexion->newInstanceArgs($argumentos);
    }
}

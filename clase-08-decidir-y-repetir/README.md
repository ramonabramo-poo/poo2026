# Clase 8 · Decidir y repetir

<p align="center"><img src="../img/emojis/pensando.webp" width="120" alt="El profesor piensa"></p>

> 📕 **Apuntes en PDF:** [clase-08-decidir-y-repetir.pdf](clase-08-decidir-y-repetir.pdf)

`if`, `match`, `for`, `while`, `foreach`… Ya los conocéis. En la clase 5 visteis **cómo se escriben**. Hoy vamos a por lo difícil de verdad: **cómo se piensa** un programa que decide y repite.

Os lo digo por experiencia: casi nadie se atasca por no recordar la sintaxis de un `for`. La gente se atasca delante de la pantalla en blanco, sin saber por dónde empezar. Así que hoy escribimos menos teoría y resolvemos más problemas.

---

## Índice

1. [Pensar antes de programar](#-1-pensar-antes-de-programar)
2. [Menos ifs dentro de ifs](#-2-menos-ifs-dentro-de-ifs)
3. [match: elegir entre muchas opciones](#-3-match-elegir-entre-muchas-opciones)
4. [¿Qué bucle uso?](#-4-qué-bucle-uso)
5. [Tres patrones que vais a usar siempre](#-5-tres-patrones-que-vais-a-usar-siempre)
6. [while: repetir sin saber cuántas veces](#-6-while-repetir-sin-saber-cuántas-veces)
7. [break y continue](#-7-break-y-continue)
8. [Bucles dentro de bucles](#-8-bucles-dentro-de-bucles)
9. [Ejercicios](#-9-ejercicios)
10. [Lo que tenéis que llevaros de hoy](#-10-lo-que-tenéis-que-llevaros-de-hoy)

> 📁 Trabajad en `php-paso-a-paso/clase08/`. Ejemplos en [`ejemplos/`](ejemplos/) y soluciones en [`soluciones/`](soluciones/).

---

## <img src="../img/emojis/pensando.webp" width="40" alt=""> 1. Pensar antes de programar

Antes de tocar el teclado, escribid la solución **en español**, como si se la explicarais a alguien. A eso se le llama **pseudocódigo**. Parece una pérdida de tiempo y es justo lo contrario.

**Problema:** ¿puede una persona presentarse al examen práctico del carné?

```text
SI tiene 18 años o más
    SI ha aprobado el teórico → "Puede presentarse al práctico"
    SI NO                     → "Tiene que aprobar el teórico"
SI NO → "Todavía no tiene edad"
```

Ahora traducirlo a PHP es casi copiar:

```php
<?php
$edad = 19;
$teoricoAprobado = false;

if ($edad >= 18) {
    if ($teoricoAprobado) {
        echo "Puede presentarse al práctico";
    } else {
        echo "Tiene que aprobar el teórico";
    }
} else {
    echo "Todavía no tiene edad";
}
```

📄 Ejemplo: [`01-pensar-antes.php`](ejemplos/01-pensar-antes.php)

### Mi receta en cuatro pasos

| Paso | Pregunta que os tenéis que hacer |
|---|---|
| 1. **Datos** | ¿Qué información tengo? (edad, teórico aprobado) |
| 2. **Resultado** | ¿Qué tengo que mostrar? (uno de tres mensajes) |
| 3. **Pseudocódigo** | ¿Cómo lo resolvería yo a mano, paso a paso? |
| 4. **Prueba** | ¿Qué valores uso para comprobar **todos** los caminos? |

El paso 4 es el que más se olvida. Aquí hay tres caminos, así que necesitáis al menos tres pruebas: 16 años; 19 sin teórico; 19 con teórico.

---

## <img src="../img/emojis/ok.webp" width="40" alt=""> 2. Menos ifs dentro de ifs

El código anterior funciona, pero cada `if` dentro de otro añade un nivel de sangría. Con tres o cuatro niveles, el código se convierte en una escalera imposible de leer.

El truco es **descartar primero los casos que no cumplen**. Lo que queda al final es el caso bueno:

```php
<?php
if ($edad < 18) {
    echo "Todavía no tiene edad";
} elseif (!$teoricoAprobado) {
    echo "Tiene que aprobar el teórico";
} else {
    echo "Puede presentarse al práctico";
}
```

📄 Ejemplo: [`02-if-plano.php`](ejemplos/02-if-plano.php)

Mismo resultado, un solo nivel. Se lee de arriba abajo como una lista de comprobaciones, igual que hace el portero de una discoteca: «¿Edad? No. Fuera. ¿Entrada? No. Fuera. Adelante». 😄

> 🎯 Cuando un `elseif` depende de los anteriores, **el orden importa**. Lo veréis en el FizzBuzz de los ejercicios.

### ⚠️ La trampa del igual solitario

```php
<?php
if ($x = 10) {      // ❌ esto NO compara: GUARDA un 10 en $x
    echo "Siempre entra";
}

if ($x === 10) {    // ✅ esto sí compara
    echo "Solo entra si vale 10";
}
```

Con un solo `=`, PHP guarda el 10 en `$x` y, como 10 cuenta como verdadero, **siempre** entra en el `if`. No da ningún error: simplemente hace algo distinto de lo que queríais. Es de los fallos más difíciles de ver, así que revisad vuestras condiciones: dentro de un `if`, tres iguales.

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 3. match: elegir entre muchas opciones

Cuando una variable puede tener muchos valores y cada uno da un resultado, `match` queda mucho más limpio que una ristra de `elseif` [1].

```php
<?php
$dia = 6;   // 1 = lunes … 7 = domingo

$tipo = match ($dia) {
    1, 2, 3, 4, 5 => "laborable",
    6, 7          => "fin de semana",
    default       => "día incorrecto",
};
```

Y con `match (true)` podéis usar condiciones en lugar de valores fijos:

```php
<?php
$calificacion = match (true) {
    $nota >= 9 => "Sobresaliente",
    $nota >= 7 => "Notable",
    $nota >= 5 => "Aprobado",
    default    => "Suspenso",
};
```

📄 Ejemplo: [`03-match.php`](ejemplos/03-match.php)

| Usad… | Cuando… |
|---|---|
| `if` / `elseif` | Hay que **hacer cosas** distintas (varias instrucciones por caso) |
| `match` | Hay que **obtener un valor** según otro valor |

> 💥 Si ningún caso coincide y **no** habéis puesto `default`, PHP se detiene con un error `UnhandledMatchError`. Parece una molestia, pero es una ventaja: os avisa de un caso que no habíais previsto en lugar de seguir como si nada.

> ⚠️ `match` compara con `===`. Si `$dia` vale `"6"` (texto), no coincide con `6`. Recordad la clase 7: convertid primero.

---

## <img src="../img/emojis/explica.webp" width="40" alt=""> 4. ¿Qué bucle uso?

Esta tabla resuelve el 95 % de las dudas [2]:

| Situación | Bucle | Ejemplo |
|---|---|---|
| Recorrer **todos** los elementos de un array | `foreach` | Mostrar la lista de alumnos |
| Repetir un **número conocido** de veces | `for` | Tabla del 7, del 1 al 10 |
| Repetir **mientras** se cumpla algo, sin saber cuántas veces | `while` | Pedir una contraseña hasta que sea correcta |

`do...while` es un `while` que se ejecuta **al menos una vez**. Existe, pero lo usaréis muy poco.

---

## <img src="../img/emojis/bien.webp" width="40" alt=""> 5. Tres patrones que vais a usar siempre

Casi todos los problemas con bucles son una combinación de estos tres patrones. Aprendéoslos de memoria.

### 🔢 Contador y ➕ acumulador

- Un **contador** empieza en 0 y suma **1** cada vez que pasa algo.
- Un **acumulador** empieza en 0 y suma **el valor** de cada elemento.

```php
<?php
$notas = [7, 4, 9, 5, 3, 8];
$aprobados = 0;   // contador
$suma = 0;        // acumulador

foreach ($notas as $nota) {
    $suma += $nota;
    if ($nota >= 5) {
        $aprobados++;
    }
}

echo "Aprobados: $aprobados";                     // 4
echo "Media: " . round($suma / count($notas), 2); // 6
```

📄 Ejemplo: [`04-contador-acumulador.php`](ejemplos/04-contador-acumulador.php)

> ⚠️ El error típico: crear el contador **dentro** del bucle. Entonces vuelve a 0 en cada vuelta y siempre acaba valiendo 0 o 1. Se inicializa **antes**.

### 🏆 Buscar el máximo (o el mínimo)

Suponemos que el primero es el mayor y vamos comparando con los demás. Si aparece uno mayor, ocupa su lugar.

```php
<?php
$temperaturas = [18, 23, 21, 27, 19, 25, 22];
$maxima = $temperaturas[0];

for ($i = 1; $i < count($temperaturas); $i++) {
    if ($temperaturas[$i] > $maxima) {
        $maxima = $temperaturas[$i];
    }
}
echo "Máxima: $maxima ºC";   // 27
```

📄 Ejemplo: [`05-buscar-maximo.php`](ejemplos/05-buscar-maximo.php) (además dice qué día fue)

Sí, PHP tiene la función `max()` y lo hace en una línea. Pero el patrón os servirá para cosas que `max()` no sabe hacer, como encontrar **al alumno** con la mejor nota.

---

## <img src="../img/emojis/curioso.webp" width="40" alt=""> 6. while: repetir sin saber cuántas veces

Pensad en fregar platos: **mientras** quede alguno en la pila, cogéis uno, lo laváis y lo dejáis en el escurridor. No sabéis de antemano cuántos hay; simplemente paráis cuando la pila está vacía.

```php
<?php
$platosEnPila = 3;

while ($platosEnPila > 0) {
    echo "Fregando un plato. Quedan {$platosEnPila}<br>";
    $platosEnPila--;   // ¡sin esta línea, no acabaríais nunca!
}
echo "¡Pila limpia!";
```

📄 Ejemplo: [`06-while-platos.php`](ejemplos/06-while-platos.php)

Otro ejemplo: el ordenador «piensa» un número del 1 al 20 y va probando números al azar hasta acertarlo. ¿Cuántos intentos necesitará? Ni idea. Por eso usamos `while`.

```php
<?php
$secreto = random_int(1, 20);
$intentos = 0;
$numero = 0;

while ($numero !== $secreto) {
    $numero = random_int(1, 20);
    $intentos++;
    echo "Intento $intentos: $numero<br>";
}
echo "¡Acertado! Ha necesitado $intentos intentos.";
```

📄 Ejemplo: [`07-while-adivina.php`](ejemplos/07-while-adivina.php)

`random_int(min, max)` devuelve un entero aleatorio entre los dos valores, ambos incluidos [3]. Recargad la página varias veces: cada vez sale distinto.

> 😱 **El bucle infinito.** Si la condición del `while` nunca deja de cumplirse, el bucle no termina. Comprobad siempre que **algo dentro del bucle cambia** la condición. Si os pasa, no os asustéis: PHP corta la ejecución a los 30 segundos por defecto.

---

## <img src="../img/emojis/atencion.webp" width="40" alt=""> 7. break y continue

| Instrucción | Qué hace | Analogía |
|---|---|---|
| `continue` | Se salta **esta vuelta** y pasa a la siguiente | Saltarse una canción de la lista |
| `break` | **Sale** del bucle por completo [4] | Apagar la música |

```php
<?php
// continue: del 1 al 10 sin los múltiplos de 3
for ($i = 1; $i <= 10; $i++) {
    if ($i % 3 === 0) {
        continue;
    }
    echo "$i ";        // 1 2 4 5 7 8 10
}

// break: dejamos de buscar en cuanto lo encontramos
foreach ($productos as $producto) {
    if ($producto === "huevos") {
        echo "¡Encontrado!";
        break;
    }
}
```

📄 Ejemplo: [`08-break-continue.php`](ejemplos/08-break-continue.php)

---

## <img src="../img/emojis/sorpresa.webp" width="40" alt=""> 8. Bucles dentro de bucles

Un bucle puede ir dentro de otro. Pensad en un reloj: por cada vuelta de la aguja de las horas, la de los minutos da una vuelta completa.

El ejemplo clásico es una tabla: el bucle de fuera recorre las **filas** y el de dentro, las **columnas** de cada fila. Fijaos en que aquí uso la **sintaxis alternativa** y el **echo corto**, porque estamos mezclando PHP con mucho HTML:

```php
<table>
    <?php for ($fila = 1; $fila <= 10; $fila++): ?>
        <tr>
            <?php for ($col = 1; $col <= 10; $col++): ?>
                <td><?= $fila * $col ?></td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>
```

📄 Ejemplo: [`09-bucles-anidados.php`](ejemplos/09-bucles-anidados.php) (con cabeceras y algo de estilo)

¿Cuántas veces se ejecuta la línea del `<td>`? 10 filas × 10 columnas = **100 veces**.

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 9. Ejercicios

Para cada ejercicio: **pseudocódigo primero**, código después y, al final, pruebas que pasen por todos los caminos.

- [ ] **01 · Entrada de cine.** Precio normal 9 €. Menores de 4 años, gratis. Menores de 14 o mayores de 65, 6 €. Los miércoles, 5 € para el resto. → [`ej01-entrada-cine.php`](soluciones/ej01-entrada-cine.php)
- [ ] **02 · Estación del año.** Con `match`, a partir del número de mes. → [`ej02-estacion.php`](soluciones/ej02-estacion.php)
- [ ] **03 · Pares.** Cuántos números pares hay entre 1 y 100 y cuánto suman. Debe dar 50 y 2550. → [`ej03-suma-pares.php`](soluciones/ej03-suma-pares.php)
- [ ] **04 · FizzBuzz.** Del 1 al 30: si es múltiplo de 3, «Fizz»; de 5, «Buzz»; de los dos, «FizzBuzz»; si no, el número. → [`ej04-fizzbuzz.php`](soluciones/ej04-fizzbuzz.php)
- [ ] **05 · Notas de la clase.** Con un array de alumnos (nombre y nota), calculad la media, cuántos aprueban y quién tiene la mejor nota. → [`ej05-notas-clase.php`](soluciones/ej05-notas-clase.php)
- [ ] **06 · Triángulo.** Dibujad un triángulo de asteriscos de 5 filas con dos bucles. → [`ej06-triangulo.php`](soluciones/ej06-triangulo.php)

> 🏆 **Reto:** en el FizzBuzz, poned la comprobación de «FizzBuzz» al final en lugar de al principio. ¿Qué pasa con el 15? Explicad por qué.

---

## <img src="../img/emojis/hola.webp" width="40" alt=""> 10. Lo que tenéis que llevaros de hoy

| Idea | En una frase |
|---|---|
| Pseudocódigo | Resolvedlo en español antes de escribir PHP |
| Pruebas | Una prueba por cada camino del programa |
| Menos anidación | Descartad primero los casos que no cumplen |
| `match` | Para obtener un valor según otro. Compara con `===` |
| `=` frente a `===` | Dentro de un `if`, siempre tres iguales |
| Qué bucle | `foreach` para arrays, `for` si sabéis cuántas veces, `while` si no |
| Patrones | Contador, acumulador y buscar el máximo |
| `break` / `continue` | Salir del bucle / saltar a la siguiente vuelta |

---

**Clase anterior:** 👈 [Clase 7 · Datos y operadores, ahora con calma](../clase-07-datos-y-operadores/README.md)
**Clase siguiente:** 👉 [Clase 9 · Funciones](../clase-09-funciones/README.md)

---

### Fuentes y Documentación Oficial

1. [Manual de PHP: match](https://www.php.net/manual/es/control-structures.match.php)
2. [Manual de PHP: estructuras de control](https://www.php.net/manual/es/language.control-structures.php)
3. [Manual de PHP: random_int](https://www.php.net/manual/es/function.random-int.php)
4. [Manual de PHP: break](https://www.php.net/manual/es/control-structures.break.php)

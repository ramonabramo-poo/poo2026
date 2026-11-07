# Clase 7 · Datos y operadores, ahora con calma

<p align="center"><img src="../img/emojis/explica.webp" width="120" alt="El profesor explica"></p>

> 📕 **Apuntes en PDF:** [clase-07-datos-y-operadores.pdf](clase-07-datos-y-operadores.pdf)

En las clases 4 a 6 fuimos deprisa a propósito: quería que vierais PHP funcionando cuanto antes. Ahora toca lo contrario. **Vamos despacio**, volvemos a los datos y a los operadores, y nos paramos en los detalles que más errores provocan al empezar.

Os aviso: hoy no hay nada «nuevo y espectacular». Hay algo mejor. Vais a entender **por qué** PHP se comporta como se comporta, y eso os ahorrará muchas horas de buscar fallos.

---

## Índice

- [Cómo vamos a trabajar a partir de ahora](#-cómo-vamos-a-trabajar-a-partir-de-ahora)
1. [Las variables son cajas con etiqueta](#-1-las-variables-son-cajas-con-etiqueta)
2. [Los cinco tipos de datos básicos](#-2-los-cinco-tipos-de-datos-básicos)
3. [Textos: comillas simples, dobles y llaves](#-3-textos-comillas-simples-dobles-y-llaves)
4. [Constantes: cajas grabadas en piedra](#-4-constantes-cajas-grabadas-en-piedra)
5. [Cuando PHP convierte tipos por su cuenta](#-5-cuando-php-convierte-tipos-por-su-cuenta)
6. [Comparar bien: == frente a ===](#-6-comparar-bien--frente-a-)
7. [null, el operador ?? y el ternario](#-7-null-el-operador--y-el-ternario)
8. [Operadores lógicos y paréntesis](#-8-operadores-lógicos-y-paréntesis)
9. [Redondear y mostrar números](#-9-redondear-y-mostrar-números)
10. [Los errores típicos de hoy](#-10-los-errores-típicos-de-hoy)
11. [Ejercicios](#-11-ejercicios)
12. [Lo que tenéis que llevaros de hoy](#-12-lo-que-tenéis-que-llevaros-de-hoy)

---

## <img src="../img/emojis/ok.webp" width="40" alt=""> Cómo vamos a trabajar a partir de ahora

Desde esta clase hasta la 12 trabajaremos en un proyecto nuevo, **`php-paso-a-paso`**, con una subcarpeta por clase:

1. En Laragon, pulsad **Raíz** y cread la carpeta **`php-paso-a-paso`**.
2. Dentro, cread la carpeta **`clase07`**.
3. Pulsad **Recargar** en Laragon para que cree el virtual host.
4. Abrid `php-paso-a-paso` en VS Code.
5. Cada archivo se abrirá en `http://php-paso-a-paso.test/clase07/nombre-del-archivo.php`.

El método es el de siempre: **leer, escribir el ejemplo vosotros y comprobarlo**. En cada clase tenéis dos carpetas:

| Carpeta | Para qué sirve |
|---|---|
| [`ejemplos/`](ejemplos/) | Los ejemplos de la explicación, para comparar si algo no os funciona |
| [`soluciones/`](soluciones/) | Una solución posible de cada ejercicio. **Miradla solo después de intentarlo** |

> 💡 Una solución «posible»: si la vuestra es distinta y funciona, está bien. En programación casi nunca hay una única forma de hacer las cosas.

---

## <img src="../img/emojis/pensando.webp" width="40" alt=""> 1. Las variables son cajas con etiqueta

Imaginad una mudanza. Cada caja lleva una **etiqueta** escrita con rotulador («libros», «cocina») y dentro hay **algo**. Una variable es exactamente eso:

```text
   $nombre          $edad          $apodo
 ┌─────────┐     ┌─────────┐     ┌─────────┐
 │ "Lucía" │     │   25    │     │  (nada) │
 └─────────┘     └─────────┘     └─────────┘
  etiqueta +      etiqueta +      la caja existe,
  contenido       contenido       pero está vacía
```

- La **etiqueta** es el nombre de la variable, siempre con `$` delante.
- El **contenido** es el valor que guardáis con `=`.
- Podéis **cambiar el contenido** cuando queráis: `$edad = 26;` tira el 25 y guarda el 26.

Pero ojo: la analogía tiene un límite. En una caja real podéis meter varias cosas; en una variable sencilla, **solo un valor**. Para guardar varios valores juntos usaremos arrays (clase 10).

---

## <img src="../img/emojis/bien.webp" width="40" alt=""> 2. Los cinco tipos de datos básicos

Cada contenido tiene un **tipo**: no es lo mismo un número que un texto. PHP lo deduce solo a partir del valor [1].

```php
<?php
$edad = 25;            // int: número entero
$altura = 1.72;        // float: número con decimales (¡con punto!)
$nombre = "Lucía";     // string: texto
$esAlumna = true;      // bool: verdadero o falso
$apodo = null;         // null: la caja existe, pero está vacía

var_dump($edad);       // int(25)
var_dump($nombre);     // string(6) "Lucía"
echo gettype($edad);   // integer
```

📄 Ejemplo: [`01-tipos.php`](ejemplos/01-tipos.php)

| Tipo | Qué guarda | Ejemplo | Lo que muestra `var_dump()` |
|---|---|---|---|
| `int` | Enteros, positivos o negativos | `25`, `-3` | `int(25)` |
| `float` | Números con decimales | `1.72`, `19.99` | `float(1.72)` |
| `string` | Texto entre comillas | `"Lucía"` | `string(6) "Lucía"` |
| `bool` | Solo `true` o `false` | `true` | `bool(true)` |
| `null` | Ausencia de valor | `null` | `NULL` |

Dos curiosidades que os vais a encontrar en el ejemplo:

- `"Lucía"` tiene 5 letras, pero `var_dump()` dice `string(6)`. No es un error: cuenta **bytes**, y la «í» ocupa dos. Volveremos a esto con los textos en la clase 10.

Y una más que confunde mucho: si hacéis `echo` de una variable que vale `false`, **no aparece nada** en pantalla. `echo` convierte `false` en un texto vacío. Para ver lo que hay de verdad dentro de la caja, `var_dump()` [2].
- `gettype()` llama `double` a los `float`. Es un nombre antiguo; significa lo mismo.

---

## <img src="../img/emojis/explica.webp" width="40" alt=""> 3. Textos: comillas simples, dobles y llaves

Buena parte del trabajo de una web es **montar textos**: «Hola, Laura», «Tienes 3 productos en el carrito»… Por eso conviene tener claro cómo se escriben [3].

| Comillas | Qué hace PHP | `'Hola $alumna'` / `"Hola $alumna"` |
|---|---|---|
| Simples `' '` | Nada: el texto sale **tal cual** | `Hola $alumna` |
| Dobles `" "` | Busca variables dentro y las **sustituye** | `Hola Laura` |

```php
<?php
$alumna = "Laura";
$modulo = "PHP 8";

echo 'Bienvenida $alumna al curso de $modulo';     // literal
echo "Bienvenida $alumna al curso de $modulo";     // sustituye
echo "Bienvenida {$alumna} al curso de {$modulo}"; // sustituye (con llaves)
echo "Bienvenida " . $alumna . " al aula.";        // concatenando con el punto
```

¿Para qué sirven las **llaves** `{$variable}`? Para que PHP sepa exactamente dónde empieza y dónde acaba la variable:

```php
<?php
$cantidad = 3;
$unidad = "kilo";
echo "Compra {$cantidad} {$unidad}s de naranjas";   // Compra 3 kilos de naranjas
```

Sin llaves, PHP buscaría una variable llamada `$unidads`… que no existe. 😅

> 🎯 **Mi recomendación:** comillas dobles con llaves cuando haya variables dentro; comillas simples cuando el texto sea fijo.

📄 Ejemplo: [`02-comillas.php`](ejemplos/02-comillas.php) (incluye cómo poner comillas dentro de un texto)

---

## <img src="../img/emojis/ok.webp" width="40" alt=""> 4. Constantes: cajas grabadas en piedra

Si una variable es una caja cuyo contenido puede cambiar, una **constante** es una caja **grabada en piedra**: le dais un valor al principio y nadie puede cambiarlo después [4].

```php
<?php
const IVA = 0.21;                        // forma recomendada
define("NOMBRE_TIENDA", "La Tiendita");  // forma clásica

echo "Bienvenidos a " . NOMBRE_TIENDA;
echo "Precio con IVA: " . 100 * (1 + IVA) . " €";   // 121 €
```

| Regla | Ejemplo |
|---|---|
| **No** llevan `$` | `IVA`, no `$IVA` |
| Se escriben en MAYÚSCULAS (por convenio) | `NOMBRE_TIENDA` |
| No se pueden cambiar | `IVA = 0.10;` da error |

¿Cuándo usarlas? Para datos que **no deben cambiar nunca** mientras se ejecuta el programa: el IVA, el nombre de la web, el número máximo de intentos…

📄 Ejemplo: [`03-constantes.php`](ejemplos/03-constantes.php)

---

## <img src="../img/emojis/sorpresa.webp" width="40" alt=""> 5. Cuando PHP convierte tipos por su cuenta

PHP es un lenguaje **flexible**: si le dais un texto donde espera un número, intenta convertirlo. A veces es cómodo. Otras veces da sorpresas [5].

```php
<?php
$a = "5" + 3;          // el + suma números → int(8)
$b = "5" . 3;          // el . une textos   → string(2) "53"
```

Fijaos bien: **el operador decide**. El `+` dice «quiero números» y el `.` dice «quiero texto». Mismos datos, resultado distinto.

### Convertir nosotros: el *casting*

Podemos forzar la conversión poniendo el tipo entre paréntesis:

```php
<?php
$precio = (float) "19.99";   // float(19.99)
$entero = (int) 7.9;         // int(7)  ← ¡corta, no redondea!
$texto  = (string) 42;       // string(2) "42"
```

> ⚠️ `(int) 7.9` da **7**, no 8. Si queréis redondear, usad `round()` (lo vemos en el punto 7).

### ¿Qué es «falso» para PHP?

Cuando PHP necesita un `bool` (por ejemplo, en un `if`), convierte el valor. Solo estos valores se consideran **falsos**:

| Valor | ¿Falso? |
|---|---|
| `false` | ✅ |
| `0` y `0.0` | ✅ |
| `""` (texto vacío) | ✅ |
| `"0"` (el texto cero) | ✅ ← este pilla a todo el mundo |
| `null` | ✅ |
| `[]` (array vacío) | ✅ |

**Todo lo demás es verdadero**: `"hola"`, `-1`, `" "` (un espacio) e incluso el texto `"false"`.

📄 Ejemplo: [`04-conversion.php`](ejemplos/04-conversion.php)

---

## <img src="../img/emojis/atencion.webp" width="40" alt=""> 6. Comparar bien: == frente a ===

Este es, probablemente, el punto más importante de hoy.

| Operador | Qué compara | `5 == "5"` / `5 === "5"` |
|---|---|---|
| `==` | Solo el valor (convierte tipos si hace falta) | `true` |
| `===` | El valor **y** el tipo | `false` |
| `!=` | Distinto valor | |
| `!==` | Distinto valor **o** distinto tipo | |

Una analogía: `==` es un portero de discoteca que solo mira la cara; `===` además os pide el DNI. 😄

¿Por qué importa tanto? Porque **los formularios y la URL siempre envían texto**. Mirad este caso real:

```php
<?php
$edadDelFormulario = "18";       // llega como texto

if ($edadDelFormulario === 18) { // "18" no es 18: nunca entra
    echo "Tiene 18 años";
}

// Lo correcto: convertir primero y comparar después
$edad = (int) $edadDelFormulario;
if ($edad === 18) {
    echo "Ahora sí: tiene 18 años";
}
```

📄 Ejemplo: [`05-comparar.php`](ejemplos/05-comparar.php)

> 🎯 **Mi recomendación:** usad siempre `===` y `!==`. Si los tipos no coinciden, convertid vosotros antes de comparar. Así el código hace lo que leéis, sin conversiones escondidas [6].

---

## <img src="../img/emojis/curioso.webp" width="40" alt=""> 7. null, el operador ?? y el ternario

`null` significa «aquí no hay nada». No es cero ni un texto vacío: es **ausencia de valor** [7].

¿Y para qué lo queremos? Para casos tan normales como un dato que el usuario no ha rellenado. Aquí entra el **operador de fusión de null**, `??`, que significa: «usa esto y, si no existe o es `null`, usa lo otro».

```php
<?php
$apodo = null;
echo $apodo ?? "Sin apodo";     // Sin apodo

// Su uso estrella: leer datos de la URL sin errores
// Probad: 06-null-ternario.php?nombre=Ana
$nombre = $_GET["nombre"] ?? "invitado";
echo "Hola, " . htmlspecialchars($nombre);
```

Sin `??` tendríais que escribir un `if` con `isset()` cada vez. Comparad:

```php
<?php
if (isset($_GET["nombre"])) {
    $nombre = $_GET["nombre"];
} else {
    $nombre = "invitado";
}
```

Cinco líneas contra una. Así de simple.

### El operador ternario: un if/else de una línea

Otro atajo que veréis muchísimo [6]:

```php
<?php
// (condición) ? valor si es verdad : valor si es mentira
$mensaje = ($edad >= 18) ? "Pase adelante" : "Acceso denegado";

// Perfecto para mostrar un bool de forma legible
echo "Matriculada: " . ($matriculada ? "sí" : "no");
```

Usadlo solo para elecciones **sencillas** entre dos valores. Si necesitáis más, volved al `if` de toda la vida.

📄 Ejemplo: [`06-null-ternario.php`](ejemplos/06-null-ternario.php)

### ✅ Dos pruebas para comprobarlo

| Haced esto | Debéis obtener |
|---|---|
| Abrid `06-null-ternario.php` sin nada más | Hola, invitado |
| Añadid `?nombre=Ana` al final de la dirección | Hola, Ana |

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 8. Operadores lógicos y paréntesis

Ya los visteis en la clase 5. Hoy añadimos lo que os faltaba: **el orden en que se evalúan**.

```php
<?php
$edad = 20;
$tieneEntrada = true;
$esVip = false;

if ($edad >= 18 && $tieneEntrada) { echo "Puede entrar"; }  // Y
if ($esVip || $tieneEntrada)      { echo "Tiene acceso"; }  // O
if (!$esVip)                      { echo "No es VIP"; }     // NO
```

Igual que en matemáticas, unos operadores van antes que otros [8]:

```php
<?php
echo 2 + 3 * 4;      // 14: primero la multiplicación
echo (2 + 3) * 4;    // 20: los paréntesis mandan
```

Con `&&` y `||` pasa lo mismo: `&&` se evalúa antes que `||`. ¿Os vais a acordar de eso dentro de un mes? Yo prefiero no depender de mi memoria:

```php
<?php
// Descuento para menores de 26 o mayores de 65, siempre que tengan entrada
$descuento = ($edad < 26 || $edad >= 65) && $tieneEntrada;
```

> 🎯 **Regla práctica:** cuando mezcléis `&&` y `||`, **poned paréntesis siempre**. Cuestan dos caracteres y evitan muchos disgustos.

> ⚠️ PHP también acepta `and` y `or` escritos con letras, pero **no los uséis**: se evalúan *después* del `=` y producen resultados absurdos. Lo veréis en el punto 10.

📄 Ejemplo: [`07-logicos-precedencia.php`](ejemplos/07-logicos-precedencia.php)

---

## <img src="../img/emojis/ok.webp" width="40" alt=""> 9. Redondear y mostrar números

Calculad el precio de algo de 59,90 € con IVA y PHP os dirá `72.479`. Correcto… pero nadie paga 72,479 €. Necesitamos **redondear** y **mostrar** el número como se hace en España.

```php
<?php
$total = 59.90 * 1.21;           // 72.479

echo round($total, 2);           // 72.48
echo floor(7.9);                 // 7  → siempre hacia abajo
echo ceil(7.1);                  // 8  → siempre hacia arriba

// number_format(número, decimales, separador decimal, separador de miles)
echo number_format($total, 2, ",", ".") . " €";   // 72,48 €
```

| Función | Qué hace | Ejemplo | Resultado |
|---|---|---|---|
| `round()` | Redondea a los decimales indicados [9] | `round(72.479, 2)` | `72.48` |
| `floor()` | Redondea hacia abajo | `floor(7.9)` | `7` |
| `ceil()` | Redondea hacia arriba | `ceil(7.1)` | `8` |
| `number_format()` | Devuelve un **texto** con formato [10] | `number_format(1234.5, 2, ",", ".")` | `"1.234,50"` |
| `intdiv()` | División entera | `intdiv(17, 5)` | `3` |
| `%` | Resto de la división | `17 % 5` | `2` |

> ⚠️ `number_format()` devuelve **texto**. Usadlo solo para mostrar el resultado, al final. Si seguís calculando con él, os llevaréis sorpresas.

📄 Ejemplo: [`08-redondeo-formato.php`](ejemplos/08-redondeo-formato.php)

---

## <img src="../img/emojis/error.webp" width="40" alt=""> 10. Los errores típicos de hoy

| Error | Qué pasa | Cómo se escribe bien |
|---|---|---|
| Olvidar el `$` | `edad = 25;` → *syntax error* | `$edad = 25;` |
| Guiones en el nombre | `$mi-variable` se lee como `$mi` **menos** `variable` | `$miVariable` (*camelCase*) |
| `echo` de un `false` | No sale nada en pantalla | `var_dump($activo);` |
| Usar `or` en vez de `\|\|` | `$x = false or true;` guarda `false` | `$x = false \|\| true;` |
| Comparar con `==` | `0 == "0"` es `true` aunque los tipos no coincidan | `===` |

📄 Ejemplo: [`09-errores-tipicos.php`](ejemplos/09-errores-tipicos.php). Tiene comentadas las versiones con error: quitad las `//` una a una y leed el mensaje que os da PHP. Aprender a leer errores es la mitad del oficio.

---

## <img src="../img/emojis/genial.webp" width="40" alt=""> 11. Ejercicios

Cread los archivos en `php-paso-a-paso/clase07/`. Primero intentadlo; después comparad con la carpeta [`soluciones/`](soluciones/).

- [ ] **01 · Ficha.** Guardad nombre, edad, nota y si está matriculado. Mostrad cada dato junto a su tipo con `gettype()`. → [`ej01-ficha.php`](soluciones/ej01-ficha.php)
- [ ] **02 · Predicciones.** **Sin ejecutar**, escribid en un papel qué mostrará `var_dump()` con: `"10" + 5`, `"10" . 5`, `(int) "3.99"`, `(bool) "0"`, `10 == "10"` y `10 === "10"`. Después comprobadlo. → [`ej02-predicciones.php`](soluciones/ej02-predicciones.php)
- [ ] **03 · Ticket de compra.** 3 auriculares a 24,95 €. Mostrad la base, el IVA (21 %) y el total con formato español. → [`ej03-ticket.php`](soluciones/ej03-ticket.php)
- [ ] **04 · Saludo por la URL.** Leed `nombre` y `edad` de la URL con `??`. Si no hay edad, decidlo; si la hay, indicad si es mayor de edad o cuántos años le faltan. → [`ej04-saludo-url.php`](soluciones/ej04-saludo-url.php)
- [ ] **05 · Segundos a horas.** Convertid 4000 segundos en horas, minutos y segundos con `intdiv()` y `%`. Debe salir 1 h, 6 min y 40 s. → [`ej05-tiempo.php`](soluciones/ej05-tiempo.php)

> 🏆 **Reto:** en el ejercicio 04, probad con `?edad=abc`. ¿Qué ocurre y por qué? Pista: mirad qué devuelve `(int) "abc"`.

---

## <img src="../img/emojis/hola.webp" width="40" alt=""> 12. Lo que tenéis que llevaros de hoy

| Idea | En una frase |
|---|---|
| Tipos | `int`, `float`, `string`, `bool` y `null`. `var_dump()` os dice cuál tenéis |
| Comillas | Dobles con llaves `"{$var}"` si hay variables; simples si el texto es fijo |
| Constantes | Sin `$`, en mayúsculas y no cambian: `const IVA = 0.21;` |
| Conversión | El operador decide: `+` quiere números y `.` quiere texto |
| Casting | `(int)`, `(float)` y `(string)` convierten a mano. `(int)` corta, no redondea |
| Comparar | Usad `===` y `!==`. Los formularios siempre envían texto |
| `??` | Valor por defecto si algo no existe o es `null` |
| Ternario | `(condición) ? sí : no` para elegir entre dos valores |
| Paréntesis | Si mezcláis `&&` y `||`, ponedlos siempre |
| Números | `round()` para calcular, `number_format()` solo para mostrar |

---

**Clase anterior:** 👈 [Clases 4 a 6 · Primeros pasos con PHP](../clase-04-primeros-pasos-php/README.md)
**Clase siguiente:** 👉 [Clase 8 · Decidir y repetir](../clase-08-decidir-y-repetir/README.md)

---

### Fuentes y Documentación Oficial

1. [Manual de PHP: tipos](https://www.php.net/manual/es/language.types.php)
2. [Manual de PHP: var_dump](https://www.php.net/manual/es/function.var-dump.php)
3. [Manual de PHP: strings (cadenas de caracteres)](https://www.php.net/manual/es/language.types.string.php)
4. [Manual de PHP: constantes](https://www.php.net/manual/es/language.constants.php)
5. [Manual de PHP: manipulación de tipos](https://www.php.net/manual/es/language.types.type-juggling.php)
6. [Manual de PHP: operadores de comparación](https://www.php.net/manual/es/language.operators.comparison.php)
7. [Manual de PHP: null](https://www.php.net/manual/es/language.types.null.php)
8. [Manual de PHP: precedencia de operadores](https://www.php.net/manual/es/language.operators.precedence.php)
9. [Manual de PHP: round](https://www.php.net/manual/es/function.round.php)
10. [Manual de PHP: number_format](https://www.php.net/manual/es/function.number-format.php)

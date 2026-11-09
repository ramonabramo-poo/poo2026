<x-mail::message>
# Hola, {{ $alumno->nombre }}

Te confirmamos que tu matrícula en **{{ $curso->titulo }}** se ha anulado.

Si ha sido un error, escríbenos y lo arreglamos enseguida.

<x-mail::button :url="route('contacto')">
Contactar con la academia
</x-mail::button>

Un saludo,<br>
{{ config('app.name') }}
</x-mail::message>

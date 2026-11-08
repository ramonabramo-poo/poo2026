<x-mail::message>
# ¡Hola, {{ $alumno->nombre }}! 👋

Tu matrícula en **{{ $curso->titulo }}** está confirmada.

<x-mail::table>
| Curso | Horas | Empieza |
|:------|:-----:|:-------:|
| {{ $curso->titulo }} | {{ $curso->horas }} | {{ $curso->fecha_inicio?->format('d/m/Y') ?? 'por determinar' }} |
</x-mail::table>

<x-mail::button :url="route('cursos.show', $curso)">
Ver el curso
</x-mail::button>

¡Nos vemos en clase!<br>
{{ config('app.name') }}
</x-mail::message>

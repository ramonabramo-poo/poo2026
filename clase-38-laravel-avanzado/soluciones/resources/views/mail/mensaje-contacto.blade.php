<x-mail::message>
# 📬 {{ $asunto }}

<x-mail::panel>
{{ $mensaje }}
</x-mail::panel>

Mensaje enviado desde el formulario de contacto de {{ config('app.name') }}.
</x-mail::message>

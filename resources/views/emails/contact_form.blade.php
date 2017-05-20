@component('mail::message')
    # Novo contato

    Você recebeu um email de {{ $sender_name }} ({{ $sender_mail }}), assunto da mensage: {{ $subjectField }}

    {{ $messageField }}

    Obrigado,<br>
    {{ config('app.name') }}
@endcomponent
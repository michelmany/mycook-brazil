@component('mail::message')
    # Novo contato

    Você recebeu um email de {{ $sender_name }} ({{ $sender_mail }}).
    Assunto: {{ $subjectField }}
    Mensagem: {{ $messageField }}

@endcomponent
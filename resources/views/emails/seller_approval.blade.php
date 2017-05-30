@component('mail::message')
    # Seu cadastro foi {{ $active ? 'aprovado' : 'reprovado'}}

    Obrigado,<br>
    {{ config('app.name') }}
@endcomponent
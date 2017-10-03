@component('mail::message')
    # Seu cadastro foi {{ $active ? 'aprovado' : 'reprovado'}}

    Obrigado,
    {{ config('app.name') }}
@endcomponent
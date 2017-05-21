@component('mail::message')
    # Confirmação de cadastro

    Você acabou de se cadastrar, mas precisa esperar a aprovação.

    Obrigado,<br>
    {{ config('app.name') }}
@endcomponent
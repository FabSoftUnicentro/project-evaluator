@component('mail::message')
# Credenciais de Acesso

Olá, {{ $user->name }} você foi cadastrado na plataforma que será utilizada para avaliar os projetos da Fábrica de Software Unicentro.

@component('mail::panel')
Senha de acesso: {{ $generatedPassword }}
@endcomponent

Você pode fazer o login com seu e-mail e a senha gerada clicando no botão abaixo.

@component('mail::button', ['url' => route('login'), 'color' => 'success'])
Fazer Login
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# Novo Contato

The body of your message.

Nome: {{$data['name']}}

email: {{$data['email']}}

mensagem: {{$data['message']}}

Obrigado,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# Olá, {{ $tarefa->user->name ?? 'Usuário' }}

{{ $mensagem }}

---

**Título:** {{ $tarefa->titulo }}

**Descrição:** {{ $tarefa->descricao }}

**Data de Vencimento:** {{ \Carbon\Carbon::parse($tarefa->data_vencimento)->format('d/m/Y') }}

@endcomponent

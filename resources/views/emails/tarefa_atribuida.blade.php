@component('mail::message')
# Nova Tarefa Atribuída

Uma nova tarefa foi atribuída a você:

**Título:** {{ $tarefa->titulo }}  
**Descrição:** {{ $tarefa->descricao }}  
**Vencimento:** {{ \Carbon\Carbon::parse($tarefa->data_vencimento)->format('d/m/Y') }}

@component('mail::button', ['url' => ''])
Ver Tarefa
@endcomponent

@endcomponent

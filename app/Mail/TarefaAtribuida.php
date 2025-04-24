<?php

namespace App\Mail;

use App\Models\Tarefa;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TarefaAtribuida extends Mailable
{
    use Queueable, SerializesModels;

    public $tarefa;
    public $mensagem;

    public function __construct(Tarefa $tarefa, $mensagem = 'Nova tarefa atribuída a você')
    {
        $this->tarefa = $tarefa;
        $this->mensagem = $mensagem;
    }

    public function build()
    {
        return $this->subject($this->mensagem)
                    ->markdown('emails.tarefa_atribuida');
    }
}

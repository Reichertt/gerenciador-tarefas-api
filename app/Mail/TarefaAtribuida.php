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

    public function __construct(Tarefa $tarefa)
    {
        $this->tarefa = $tarefa;
    }

    public function build()
    {
        return $this->subject('Nova tarefa atribuída a você')
                    ->markdown('emails.tarefa_atribuida');
    }
}

<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TarefaAtribuida extends Notification
{
    public $tarefa;

    public function __construct($tarefa)
    {
        $this->tarefa = $tarefa;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Nova tarefa atribuída a você')
            ->line("Título: {$this->tarefa->titulo}")
            ->line("Descrição: {$this->tarefa->descricao}")
            ->line("Data de vencimento: {$this->tarefa->data_vencimento}")
            ->line('Acesse o sistema para mais detalhes.');
    }
}


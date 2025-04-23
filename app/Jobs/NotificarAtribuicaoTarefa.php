<?php

namespace App\Jobs;

use App\Mail\TarefaAtribuida;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\User;
use App\Models\Tarefa;

class NotificarAtribuicaoTarefa implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tarefa;

    public function __construct(Tarefa $tarefa)
    {
        $this->tarefa = $tarefa;
    }

    public function handle(): void
    {
        $user = $this->tarefa->user;

        if ($user && $user->email) {
            Mail::to($user->email)->send(new TarefaAtribuida($this->tarefa));
        }
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tarefa;
use Illuminate\Support\Facades\Mail;
use App\Mail\TarefaAtribuida;

class NotificarTarefasVencimento extends Command
{
    protected $signature = 'notificar:vencimento';
    protected $description = 'Notifica os usuários sobre tarefas que vencem em 2 dias';

    public function handle()
    {
        $tarefas = Tarefa::whereDate('data_vencimento', now()->addDays(2))->with('user')->get();

        foreach ($tarefas as $tarefa) {
            if ($tarefa->user && $tarefa->user->email) {
                Mail::to($tarefa->user->email)->queue(
                    new TarefaAtribuida(
                        $tarefa,
                        'Sua tarefa vence em 2 dias',
                        'Aviso: tarefa prestes a vencer'
                    )
                );
            }
        }

        $this->info('Notificações enviadas com sucesso!');
    }
}

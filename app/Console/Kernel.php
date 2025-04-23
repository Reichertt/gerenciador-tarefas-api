<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Defina os comandos do Artisan personalizados.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\NotificarTarefasVencimento::class,
    ];    

    /**
     * Defina a programação dos comandos.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Agende seu comando aqui
        $schedule->command('notificar:vencimento')->dailyAt('08:00');

    }

    /**
     * Registre os comandos do aplicativo.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

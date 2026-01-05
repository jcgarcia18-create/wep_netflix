<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class CheckActiveSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisar usuarios con suscripción activa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== REVISIÓN DE SUSCRIPCIONES ACTIVAS ===');
        $this->newLine();

        // Obtener usuarios con suscripción activa
        $usersWithSubscription = User::where('suscripcion_activa', true)->get();

        $this->info("Total de usuarios con suscripcion_activa = true: " . $usersWithSubscription->count());
        $this->newLine();

        if ($usersWithSubscription->count() > 0) {
            $this->info('--- DETALLE DE USUARIOS ---');
            $this->newLine();

            $headers = ['ID', 'Nombre', 'Email', 'Expira', 'Estado', 'Días Restantes'];
            $rows = [];

            foreach ($usersWithSubscription as $user) {
                $status = '❌ NO CONFIG';
                $daysRemaining = 0;

                if ($user->suscripcion_expira) {
                    $expirationDate = Carbon::parse($user->suscripcion_expira);
                    $now = Carbon::now();
                    $isExpired = $expirationDate->isPast();
                    $daysRemaining = $isExpired ? 0 : $now->diffInDays($expirationDate);
                    $status = $isExpired ? '❌ EXPIRADA' : '✅ ACTIVA';
                }

                $rows[] = [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->suscripcion_expira ? Carbon::parse($user->suscripcion_expira)->format('d/m/Y H:i') : 'NO CONFIG',
                    $status,
                    $daysRemaining
                ];
            }

            $this->table($headers, $rows);
        } else {
            $this->warn('❌ No hay usuarios con suscripción activa.');
        }

        $this->newLine();

        // Estadísticas generales
        $totalUsers = User::count();
        $activeNow = User::where('suscripcion_activa', true)
            ->whereNotNull('suscripcion_expira')
            ->where('suscripcion_expira', '>', Carbon::now())
            ->count();

        $expired = User::where('suscripcion_activa', true)
            ->whereNotNull('suscripcion_expira')
            ->where('suscripcion_expira', '<=', Carbon::now())
            ->count();

        $noSubscription = $totalUsers - $activeNow - $expired;

        $this->info('=== ESTADÍSTICAS GENERALES ===');
        $this->newLine();
        $this->line("Total de usuarios: {$totalUsers}");
        $this->line("Suscripciones activas (no expiradas): {$activeNow}");
        $this->line("Suscripciones expiradas: {$expired}");
        $this->line("Sin suscripción: {$noSubscription}");

        if ($totalUsers > 0) {
            $percentage = round(($activeNow / $totalUsers) * 100, 2);
            $this->line("Tasa de suscripción: {$percentage}%");
        }

        $this->newLine();

        return Command::SUCCESS;
    }
}

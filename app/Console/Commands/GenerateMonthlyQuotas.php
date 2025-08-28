<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Quota;
use App\Models\Client;
use App\Models\Payments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\QuotaGeneratedMail;

class GenerateMonthlyQuotas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-monthly-quotas';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to generate monthly quotas for clients';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // funcionalidad para la generacion de quotas
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $clients = Client::with('contract')->get();
        // Verificar si ya existe la cuoata 
        $existe = Quota::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->first();
            
        if (!$existe) {
            // Crear la cuota
            $quota = Quota::create([
                'numero' => Carbon::now()->month,
            ]);

            foreach ($clients as $client) {
                // Generar un pago por cliente según su contrato
                Payments::create([
                    'id_cliente' => $client->id,
                    'id_cuota' => $quota->id,
                    'num_cuotas' => $month,
                    'costo' => $client->contract->costo, // monto según el contrato del cliente
                    'abonado' => 0,
                    'estado' => 0,
                    'fecha_pago' => null,
                    'comentario' => null
                ]);
            }

            $this->info("✅ Cuota generada para el periodo {$year}-{$month}");
            Mail::to('AlGusOf10@gmail.com')->send(new QuotaGeneratedMail($quota, 'success'));
        } else {
            Mail::to('AlGusOf10@gmail.com')->send(
                new QuotaGeneratedMail(null, 'failed', 'La cuota ya existe para este período.')
            );
            $this->warn("⚠️ La cuota ya fue generada para el periodo {$year}-{$month}");
        }
        Log::info('✔️ quotas:generate ejecutado correctamente a las ' . now());
        return Command::SUCCESS;
    }
}

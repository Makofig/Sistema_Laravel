<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Client; 
use App\Models\Payments;

class GenerateQuotaPayments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $quotaId; 
    /**
     * Create a new job instance.
     */
    public function __construct($quotaId)
    {
        $this->quotaId = $quotaId; 
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $total = Client::count();
        $processed = 0; 

        Client::with('contract')
            ->chunk(100, function ($clients) use ($total, &$processed) {

                foreach ($clients as $client) {
                    Payments::create([
                        'id_cliente' => $client->id,
                        'id_cuota' => $this->quotaId,
                        'num_cuotas' => now()->month,
                        'costo' => $client->contract->costo,
                        'abonado' => 0,
                        'estado' => 0,
                    ]);

                    $processed++;
                }

                $progress = intval(($processed / $total) * 100);

                cache()->put(
                    "quota_progress_{$this->quotaId}",
                    $progress,
                    now()->addMinutes(30)
                );
            });

        cache()->put("quota_progress_{$this->quotaId}", 100);
    }
}

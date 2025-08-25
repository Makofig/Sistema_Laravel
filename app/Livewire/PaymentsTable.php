<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Payments;
use App\Models\Client;

class PaymentsTable extends Component
{
    use withPagination;

    protected $paginationTheme = 'tailwind';

    public $clientId;

    // Esto hace que el id llegue desde la vista @livewire
    public function mount($clientId)
    {
        $this->clientId = $clientId;
    }

    public function render()
    {
        $client = Client::find($this->clientId);
        $payments = Payments::where('id_cliente', $this->clientId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.payments-table', [
            'client' => $client,
            'payments' => $payments,
        ]);
    }
}

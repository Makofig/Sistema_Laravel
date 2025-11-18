<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Client;
use App\Models\Access_Point;

class AccessClientsTable extends Component
{
    use WithPagination; 
    
    public $access_point_id;

    protected $paginationTheme = 'tailwind'; 

    // Recibe parámetros del componente
    public function mount($access_point_id)
    {
        $this->access_point_id = $access_point_id;
    }

    // Resetear paginación cuando cambien filtros (si quieres)
    public function updating($name)
    {
        $this->resetPage();
    }

    public function render()
    {
        // Obtener clientes asociados
        $clients = Client::where('id_point', $this->access_point_id)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.access-clients-table', [
            'clients' => $clients,
        ]);
    }
}

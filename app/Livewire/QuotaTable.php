<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Quota;
use Illuminate\Support\Facades\DB;

class QuotaTable extends Component
{
    use WithPagination; 

    public $search = '';

    public function updatedSearch($value)
    {   
        $this->search = strtolower(preg_replace('/\s+/', ' ', trim($value)));
        $this->resetPage();
    }
    /*
    public function filterBySearch($filterSearch)
    {
        $this->search = $filterSearch;
    }
    */
    public function render()
    {
        // buscar por el año y mes 
        $quotas = Quota::when($this->search, function ($query) {
            $query->where(DB::raw('YEAR(created_at)'), 'like', '%' . $this->search . '%')
                ->orWhere(DB::raw('MONTH(created_at)'), 'like', '%' . $this->search . '%');
        })->paginate(10);

        return view('livewire.quota-table', [
            'quotas' => $quotas,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Pedidos;
use Livewire\Component;
use Livewire\WithPagination;

class ListaPedidos extends Component
{
    use WithPagination;

    public $busqueda = '';

    public function mount()
    {
        $this->busqueda = '';
    }
    protected $updatesQueryString = ['busqueda'];
    protected $queryString = [
        'busqueda' => ['except' => ''],
    ];

    public function updatingBusqueda()
    {
        $this->resetPage(); // vuelve a la página 1 al filtrar
    }
    public function render()
    {
        return view('livewire.lista-pedidos',
            [
                'pedidos' => Pedidos::where('nota_venta', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('cliente', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('responsable', 'like', '%' . $this->busqueda . '%')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10),
            ]
        );
    }
}

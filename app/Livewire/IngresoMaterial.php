<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Productos;
use App\Models\Kardex;

class IngresoMaterial extends Component
{
    public $responsable;
    public $tipoIngreso;
    public $cantidad;
    public $codigoBarra;
    public $productoEncontrado = null;
    public $mostrarConfirmacion = false;

    protected $rules = [
        'tipoIngreso' => 'required|in:1,2',
        'cantidad' => 'required|integer|min:1',
        'codigoBarra' => 'max:255',
    ];

    protected $messages = [
        'tipoIngreso.required' => 'El tipo de ingreso es obligatorio.',
        'cantidad.required' => 'La cantidad es obligatoria.',
        'cantidad.integer' => 'La cantidad debe ser un número entero.',
        'cantidad.min' => 'La cantidad debe ser al menos 1.',
        'codigoBarra.required' => 'El código de barra es obligatorio.',
        'codigoBarra.string' => 'El código de barra debe ser una cadena de texto.',
        'codigoBarra.max' => 'El código de barra no puede exceder los 255 caracteres.',
    ];

    public function mount()
    {
        $this->responsable = auth()->user()->name ?? '';
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Al escanear código de barra o cambiarlo, buscamos el producto
    public function updatedCodigoBarra($value)
    {
        $this->productoEncontrado = Productos::where('codigo_barra_unitario', 'like', '%'.$value.'%')
            ->orWhere('codigo_barra_embalaje', 'like', '%'.$value.'%')
            ->first();

        if ($this->productoEncontrado) {
            // Enviamos evento para mostrar alerta JS con el código encontrado
            $this->dispatch('producto-encontrado', [
                'codigo' => $this->productoEncontrado->codigo,
                'nombre' => $this->productoEncontrado->descripcion,
            ]);
        } else {
            $this->dispatch('producto-no-encontrado', ['codigo' => $value]);
            $this->productoEncontrado = null;
        }
    }

    // Cuando se da click en Ingresar: mostramos el modal de confirmación
    public function confirmar()
    {
        $this->validate();

        if (!$this->productoEncontrado) {
            session()->flash('error', 'No se ha encontrado un producto válido para el código de barra.');
            return;
        }

        $this->mostrarConfirmacion = true;

        // Opcional: cerrar modal principal si usas JS para controlarlo
        $this->dispatch('close-modal', ['name' => 'ingreso-material']);
    }

    // Confirmar e ingresar material a la base de datos
    public function ingresar()
    {
        if (!$this->productoEncontrado) {
            session()->flash('error', 'No se ha encontrado un producto válido para ingresar.');
            $this->mostrarConfirmacion = false;
            return;
        }

        if ($this->tipoIngreso == 1) {
            $this->productoEncontrado->stock_total += $this->cantidad;
        } elseif ($this->tipoIngreso == 2) {
            $this->productoEncontrado->stock_total += $this->cantidad * $this->productoEncontrado->unidades_por_embalaje;
        }

        $this->productoEncontrado->save();

        // Registrar en Kardex
        Kardex::create([
            'tipo_ingreso' => 1, // 1 para ingreso
            'cantidad' => $this->cantidad,
            'producto_id' => $this->productoEncontrado->id,
            'responsable' => $this->responsable,
            'fecha_ingreso' => now(),
        ]);

        session()->flash('success', 'Material ingresado correctamente.');

        // Reset campos y ocultar modal confirmación
        $this->reset(['cantidad', 'codigoBarra', 'tipoIngreso', 'productoEncontrado', 'mostrarConfirmacion']);
    }

    public function render()
    {
        return view('livewire.ingreso-material');
    }
}

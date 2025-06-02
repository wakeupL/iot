<?php

namespace App\Livewire;

use App\Models\Kardex;
use App\Models\Pedidos;
use App\Models\ProductoSeparado;
use Livewire\Component;
use App\Models\Productos;

date_default_timezone_set('America/Santiago');

class PrepararPedido extends Component
{

    public $pedidoId;
    public $pedido;
    public $responsable;
    public $tipoIngreso;
    public $cantidad;
    public $codigoBarra;
    public $productoEncontrado = null;
    public $mostrarConfirmacion = false;

    public $productosSeparados = [];


    public function mount($pedidoId)
    {
        $this->pedidoId = $pedidoId;
        $this->pedido = Pedidos::find($pedidoId);

        $this->cargarProductosSeparados();
        session()->forget('error');
        session()->forget('success');
    }

    public function cargarProductosSeparados()
    {
        $this->productosSeparados = ProductoSeparado::where('nota_venta_id', $this->pedidoId)->with('producto')->get();
    }
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

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    // Al escanear código de barra o cambiarlo, buscamos el producto
    public function updatedCodigoBarra($value)
    {
        $this->productoEncontrado = Productos::where('codigo_barra_unitario', 'like', '%' . $value . '%')
            ->orWhere('codigo_barra_embalaje', 'like', '%' . $value . '%')
            ->first();

        if (!$this->productoEncontrado) {
            $this->dispatch('producto-no-encontrado', ['codigo' => $value]);
            session()->flash('error', 'Producto no encontrado.');
            return;
        }

        if (!is_numeric($this->cantidad) || $this->cantidad <= 0) {
            session()->flash('error', 'Cantidad ingresada no es válida.');
            return;
        }

        $stockDisponible = $this->productoEncontrado->stock_total - $this->productoEncontrado->stock_reservado;

        // Determinar la cantidad final según tipo de ingreso
        if ($this->tipoIngreso == 1) {
            $cantidadIngresada = $this->cantidad;
        } elseif ($this->tipoIngreso == 2) {
            $cantidadIngresada = $this->cantidad * $this->productoEncontrado->unidades_por_embalaje;
        } else {
            session()->flash('error', 'Tipo de ingreso inválido.');
            return;
        }

        if ($cantidadIngresada > $stockDisponible) {
            $this->productoEncontrado = null;
            $this->reset(['cantidad', 'codigoBarra', 'tipoIngreso', 'productoEncontrado', 'mostrarConfirmacion']);
            session()->flash('error', 'La cantidad solicitada supera el stock disponible del producto.');
            return;
        }

        // Producto válido y cantidad dentro del stock
        $this->dispatch('producto-encontrado', [
            'codigo' => $this->productoEncontrado->codigo,
            'nombre' => $this->productoEncontrado->descripcion,
        ]);
    }

    public function confirmar()
    {
        $this->validate();

        //dd($this->productoEncontrado)
        $this->mostrarConfirmacion = true;
    }
    public function getMaterialesSeparadosProperty()
    {
        return ProductoSeparado::with('producto')
            ->where('nota_venta_id', $this->pedidoId)
            ->latest()
            ->get();
    }

    public function ingresarProducto()
    {
        $this->validate();
        // Aquí puedes agregar la lógica para ingresar el pedido
        // Por ejemplo, crear un registro en la base de datos
        //dd($this->cantidad, $this->tipoIngreso, $this->productoEncontrado, $this->pedidoId, $this->responsable);
        ProductoSeparado::create([
            'producto_id' => $this->productoEncontrado->id,
            'cantidad' => $this->cantidad,
            'nota_venta_id' => $this->pedidoId,
            'responsable' => auth()->user()->name,
        ]);
        Kardex::create([
            'producto_id' => $this->productoEncontrado->id,
            'documento' => $this->pedido->nota_venta,
            'tipo_ingreso' => 2, // 2 para separar pedido
            'cantidad' => $this->cantidad,
            'responsable' => auth()->user()->name,
            'fecha_ingreso' => now(),
        ]);

        $this->productoEncontrado->stock_reservado += $this->cantidad;
        $this->productoEncontrado->save();
        // Simulación de ingreso exitoso
        session()->flash('success', 'Pedido preparado exitosamente.');

        // Limpiar campos después de ingresar
        $this->reset(['tipoIngreso', 'cantidad', 'codigoBarra', 'productoEncontrado']);
        // Recargar productos separados
        $this->cargarProductosSeparados();
        $this->mostrarConfirmacion = false;

        // Opcional: redirigir o actualizar el estado del pedido
    }

    public function eliminarPedido($id)
    {
        try {
            // Trae todos los productos separados asociados a ese pedido
            $productosSeparados = ProductoSeparado::where('nota_venta_id', $id)->get();

            foreach ($productosSeparados as $ps) {
                // Buscar el producto original
                $producto = Productos::find($ps->producto_id);

                if ($producto) {
                    // Restar del stock reservado
                    $producto->stock_reservado -= $ps->cantidad;
                    if ($producto->stock_reservado < 0) {
                        $producto->stock_reservado = 0; // Evitar negativos
                    }
                    $producto->save();
                }

                // Eliminar el producto separado
                $ps->delete();
            }

            Pedidos::destroy($id); // Eliminar el pedido
            session()->flash('success', 'Pedido eliminado correctamente.');

            // Opcional: recargar la lista si la estás mostrando en el mismo componente
            $this->cargarProductosSeparados();

            return redirect()->route('pedidos.index'); // Redirigir a la lista de pedidos
        } catch (\Exception $e) {
            session()->flash('error', 'Ocurrió un error al eliminar.');
        }
    }

    public function eliminarProductoSeparado($id)
    {
        $producto = ProductoSeparado::find($id);

        if ($producto) {
            // Actualizar el stock reservado del producto
            $producto->producto->stock_reservado -= $producto->cantidad;
            $producto->producto->save();
            // Eliminar el producto separado
            Kardex::create([
                'producto_id' => $producto->producto_id,
                'documento' => $this->pedido->nota_venta,
                'tipo_ingreso' => 3, // 3 para egreso
                'cantidad' => $producto->cantidad,
                'responsable' => auth()->user()->name,
                'fecha_ingreso' => now(),
            ]);
            $producto->delete();
            // Recargar productos
            $this->productosSeparados = ProductoSeparado::where('nota_venta_id', $this->pedidoId)->get();
            session()->flash('success', 'Producto eliminado correctamente.');
        } else {
            session()->flash('error', 'Producto no encontrado.');
        }
    }


    public function render()
    {
        return view('livewire.preparar-pedido');
    }
}

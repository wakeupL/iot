<div class="w-full">
    <div class="flex items-center justify-between p-4">
        <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
            Pedido #{{ $pedido->nota_venta }}</h2>

    </div>
    <table class="w-full text-center text-sm text-neutral-500 dark:text-neutral-400">
        <thead class="bg-neutral-50 text-xs uppercase text-neutral-700 dark:bg-neutral-800 dark:text-neutral-400">
            <tr>
                <th scope="col" class="px-6 py-3">ID</th>
                <th scope="col" class="px-6 py-3">NOTA DE VENTA</th>
                <th scope="col" class="px-6 py-3">CLIENTE</th>
                <th scope="col" class="px-6 py-3">RESPONSABLE</th>
                <th scope="col" class="px-6 py-3">ESTADO</th>
                <th scope="col" class="px-6 py-3">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-b bg-white dark:border-neutral-700 dark:bg-neutral-800">
                <td class="px-6 py-4">{{ $pedido->id }}</td>
                <td class="px-6 py-4">{{ $pedido->nota_venta }}</td>
                <td class="px-6 py-4">{{ $pedido->cliente }}</td>
                <td class="px-6 py-4">{{ $pedido->responsable }}</td>
                <td class="px-6 py-4">
                    @switch($pedido->estado)
                        @case('en_proceso')
                            <flux:badge color="yellow" icon="clock">
                                En Proceso
                            </flux:badge>
                        @break

                        @case('para_despacho')
                            <flux:badge color="red" icon="check">
                                Listo para Despacho
                            </flux:badge>
                        @break

                        @case('cancelado')
                            <flux:badge color="red" icon="x">
                                Despachado
                            </flux:badge>

                            @default
                        @endswitch
                    </td>
                    <td class="px-6 py-4">
                        @switch($pedido->estado_qr)
                            @case(0)
                                <flux:modal.trigger name="generar-qr">
                                    <flux:button>Generar QR</flux:button>
                                </flux:modal.trigger>

                                <flux:modal name="generar-qr" class="md:w-96">
                                    <form action="{{ route('pedido.generar-qr', $pedido->id) }}" method="POST" target="_blank">
                                        @csrf
                                        <input type="hidden" name="pedido_id" value="{{ $pedido->id }}">
                                        <div class="space-y-6">
                                            <div>
                                                <flux:heading size="lg" class="text-center">Generar QR</flux:heading>
                                                <flux:text class="mt-2">Al generar el código QR del pedido
                                                    #<strong>{{ $pedido->nota_venta }}</strong>, estás confirmando que el
                                                    proceso de separación de material ha finalizado.</flux:text>
                                            </div>

                                            <flux:input label="Cliente" name="cliente" value="{{ strtoupper($pedido->cliente) }}"
                                                readonly />
                                            <flux:input label="Nota de Venta" name="nota_venta" value="{{ $pedido->nota_venta }}"
                                                readonly />

                                            <flux:input label="Cantidad de Bultos" name="cantidad_bultos" type="number" />

                                            <div class="flex">
                                                <flux:spacer />

                                                <flux:button type="submit" variant="primary" onclick="recargarQr()">GENERAR QR</flux:button>
                                            </div>
                                        </div>
                                    </form>
                                </flux:modal>
                            @break

                            @case(1)
                                <flux:button target="_blank" href="{{route('pedido.ver-qr', $pedido->id)}}" variant="primary" icon="check">
                                    Ver QR
                                </flux:button>
                            @break

                            @default
                        @endswitch
                        <flux:modal.trigger name="eliminar-pedido">
                            <flux:button variant="danger">Eliminar Pedido</flux:button>
                        </flux:modal.trigger>

                        <flux:modal name="eliminar-pedido" class="md:w-96">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg" class="text-center">¿Confirmas eliminar pedido:
                                        {{ $pedido->nota_venta }}?</flux:heading>
                                    <flux:text class="mt-2">
                                        Todos los datos asociados a este pedido serán eliminados permanentemente.
                                    </flux:text>
                                </div>

                                <flux:input label="Responsable" name="responsable" value="{{ auth()->user()->name }}"
                                    readonly icon="user" />

                                <div class="flex">
                                    <flux:spacer />

                                    <flux:button type="submit" wire:click="eliminarPedido({{ $pedido->id }})"
                                        variant="danger">Eliminar </flux:button>
                                </div>
                            </div>
                        </flux:modal>
                    </td>
                </tr>
            </tbody>
        </table>
        <flux:spacer />
        <div class="flex items-center justify-between p-4">
            <h2 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                Listado de Materiales cargados al pedido #{{ $pedido->nota_venta }}
            </h2>
            <br>

            <div class="text-center">
                <flux:modal.trigger name="separar-material">
                    <flux:button variant="primary" icon="bars-arrow-down">
                        Añadir Material al Pedido
                    </flux:button>
                </flux:modal.trigger>

                <flux:modal name="separar-material" class="md:w-96">
                    <div class="space-y-6">
                        <div>
                            <flux:heading size="lg">
                                {{ __('AÑADIR MATERIAL A NOTA: ') }}<strong>{{ $pedido->nota_venta }}</strong>
                            </flux:heading>
                            <flux:text class="mt-2">
                                {{ __('Rellena los datos a continuación') }}
                            </flux:text>
                        </div>

                        <form wire:submit.prevent="confirmar">

                            <flux:input label="{{ __('Responsable') }}" icon="user" value="{{ auth()->user()->name }}"
                                name="responsable" readonly />
                            <br>

                            <flux:radio.group variant="segmented" wire:model="tipoIngreso"
                                label="{{ __('Tipo de Ingreso') }}">

                                <flux:radio value="1" label="{{ __('Unitario') }}" icon="squares-2x2" />
                                <flux:radio disabled label="{{ __('Seleccione') }}" />
                                <flux:radio value="2" label="{{ __('Embalaje') }}" icon="cube" />
                            </flux:radio.group>

                            <br>

                            <flux:input label="{{ __('Cantidad') }}" icon="squares-2x2" badge="Obligatorio" type="number"
                                min="1" wire:model="cantidad" placeholder="{{ __('Ingresa la cantidad') }}"
                                required />

                            <br>

                            <flux:input label="{{ __('Código de Barra') }}" icon="qr-code" badge="Obligatorio"
                                wire:model="codigoBarra" placeholder="Escanea el código de barra" />
                            <br>

                            @if ($productoEncontrado)
                                <div class="text-sm text-green-600">
                                    <strong>Producto encontrado: {{ $productoEncontrado->codigo }} -
                                        {{ $productoEncontrado->descripcion ?? 'Sin descripción' }} </strong>
                                </div>
                                <div>
                                    <flux:button wire:click="ingresarProducto" variant="danger" size="sm">
                                        Confirmar y Añadir
                                    </flux:button>
                                </div>
                            @endif

                            <div class="flex justify-end mt-4">
                                <flux:button type="submit" variant="primary">
                                    Confirmar Datos
                                </flux:button>
                            </div>

                            @if (session()->has('success'))
                                <div class="text-green-600 mt-2">{{ session('success') }}</div>
                            @endif
                            @if (session()->has('error'))
                                <div class="text-red-600 mt-2">{{ session('error') }}</div>
                            @endif
                        </form>
                    </div>
                </flux:modal>

            </div>


        </div>
        <table class="w-full text-center text-sm text-neutral-500 dark:text-neutral-100">
            <thead>
                <tr>
                    <th class="px-6 py-3">CÓDIGO</th>
                    <th class="px-6 py-3">DESCRIPCIÓN</th>
                    <th class="px-6 py-3">CANTIDAD</th>
                    <th class="px-6 py-3">RESPONSABLE</th>
                    <th class="px-6 py-3">ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($productosSeparados as $producto)
                    <tr class="border-b bg-white dark:border-neutral-700 dark:bg-neutral-800">
                        <td class="px-6 py-4">{{ $producto->producto->codigo }}</td>
                        <td class="px-6 py-4">{{ $producto->producto->descripcion }}</td>
                        <td class="px-6 py-4">{{ $producto->cantidad }}</td>
                        <td class="px-6 py-4">{{ $producto->responsable }}</td>
                        <td class="px-6 py-4">
                            @if ($pedido->estado_qr == 1)
                                <flux:button  disabled
                                icon="trash">
                                Eliminar
                            </flux:button>
                            @else
                                <flux:button wire:click="eliminarProducto({{ $producto->id }})" variant="danger"
                                icon="trash">
                                Eliminar
                            </flux:button>
                            @endif
                            

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-neutral-500">
                            Sin productos añadidos.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

<script>
    function recargarQr() {
        setTimeout(() => {
            window.location.reload();
        }, 1500); // Espera 1.5 segundos para que dé tiempo a abrir el PDF
    }
</script>

    </div>


    <div class="p-4 text-center rounded-lg mb-4">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold">Listado de Pedidos Pendientes</h2>
            <input type="text" wire:model.debounce.500ms="busqueda" placeholder="Buscar por Nota de Venta"
                class="border border-gray-50 rounded px-4 py-2 w-64" />
        </div>

        <table class="min-w-full text-sm table-fixed">
            <thead class="bg-emerald-950 font-bold">
                <tr>
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Nota de Venta</th>
                    <th class="px-4 py-2">Cliente</th>
                    <th class="px-4 py-2">Responsable</th>
                    <th class="px-4 py-2">Estado</th>
                    <th class="px-4 py-2">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $pedido->id }}</td>
                        <td class="px-4 py-2">{{ $pedido->nota_venta }}</td>
                        <td class="px-4 py-2">{{ $pedido->cliente }}</td>
                        <td class="px-4 py-2">{{ $pedido->responsable }}</td>
                        <td class="px-4 py-2">
                            @switch($pedido->estado)
                                @case('en_proceso')
                                    <span class="text-yellow-600">En proceso</span>
                                @break

                                @case('para_despacho')
                                    <span class="text-green-600">Para Despachar</span>
                                @break

                                @case('cancelado')
                                    <span class="text-red-600">Cancelado</span>
                                @break
                            @endswitch
                        </td>
                        <td class="px-4 py-2">
                            <flux:button
                                variant="primary"
                                color="green"
                                icon="list-bullet"
                                href="{{ route('pedido.preparar', $pedido->id) }}">
                                    Ver Detalle
                            </flux:button>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No hay pedidos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $pedidos->links() }}
            </div>

        </div>

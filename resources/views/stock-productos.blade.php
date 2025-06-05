<x-layouts.app :title="__('I.o.T. | Bodega -> Separar Material')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="p-10 text-center text-md text-neutral-900 dark:text-neutral-100">
                <flux:heading size="xl">{{ __('Módulo de trabajo -> Listado de Stock') }}</flux:heading>
            </div>
        </div>

        <div class="container">
            <h1 class="mb-4">Listado de Productos</h1>
            <table id="productos-table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Cod. Barra UN.</th>
                        <th>Cod. Barra. Emb.</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Reservado</th>
                        <th>Disponible</th> {{-- Nueva columna --}}
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</x-layouts.app>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        $('#productos-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('productos.data') }}',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            },
            columns: [{
                    data: 'codigo'
                },
                {
                    data: 'codigo_barra_unitario'
                },
                {
                    data: 'codigo_barra_embalaje'
                },
                {
                    data: 'descripcion'
                },
                {
                    data: 'stock_total'
                },
                {
                    data: 'stock_reservado'
                },
                {
                    data: 'disponible',
                    orderable: false,
                    searchable: false
                }, // columna calculada
            ]
        });

    });
</script>

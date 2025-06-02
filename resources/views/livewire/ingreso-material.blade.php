<div class="text-center">
    <flux:modal.trigger name="ingreso-material">
        <flux:button variant="primary" icon="bars-arrow-down">
            Ingresar Material a Bodega
        </flux:button>
    </flux:modal.trigger>

    <flux:modal name="ingreso-material" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ __('FORMULARIO DE INGRESO') }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ __('Rellena los datos a continuación') }}
                </flux:text>
            </div>

            <form wire:submit.prevent="confirmar">
                <flux:input label="{{ __('Responsable') }}" icon="user" name="responsable"
                    value="{{ auth()->user()->name }}" readonly />
                <br>

                <flux:radio.group variant="segmented" wire:model="tipoIngreso" label="{{ __('Tipo de Ingreso') }}">
                    <flux:radio value="1" label="{{ __('Unitario') }}" icon="squares-2x2" />
                    <flux:radio disabled label="{{ __('Seleccione') }}" />
                    <flux:radio value="2" label="{{ __('Embalaje') }}" icon="cube" />
                </flux:radio.group>
                <br>

                <flux:input label="{{ __('Cantidad') }}" icon="squares-2x2" badge="Obligatorio"
                    type="number" min="1" wire:model="cantidad"
                    placeholder="{{ __('Ingresa la cantidad') }}" required autofocus />
                <br>

                <flux:input label="{{ __('Código de Barra') }}" icon="qr-code" badge="Obligatorio"
                    wire:model="codigoBarra" placeholder="Escanea el código de barra" />
                <br>

                @if ($productoEncontrado)
                    <div class="text-sm text-green-600">
                        Producto encontrado: {{ $productoEncontrado->codigo }} - {{ $productoEncontrado->descripcion ?? 'Sin nombre' }}
                    </div>
                    <div>
                        <flux:button wire:click="ingresar" variant="danger" size="sm">
                        Confirmar e Ingresar
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

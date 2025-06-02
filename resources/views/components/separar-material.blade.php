<div class="overflow-hidden font-bold text-2xl text-neutral-900 dark:text-neutral-100">
    {{ __('Separar Material') }}
</div>
<br>
<flux:modal.trigger name="separar-material">
    <div class="md:pt-5text-md font-semibold text-neutral-900 dark:text-neutral-100">
        <flux:button variant="primary" icon="shopping-cart">
            {{ __('SEPARAR MATERIAL') }}</flux:button>
    </div>
</flux:modal.trigger>

<flux:modal name="separar-material" variant="flyout">
    <div class="space-y-6">
        <div>
            <flux:heading size="lg">
                {{__('Separar material')}}
            </flux:heading>
            <flux:text class="mt-2">
                {{ __('Ingresa la nota de venta para empezar a separar el material.')}}
            </flux:text>
        </div>
        <form action="{{route('pedido.registrar')}}" method="POST">
            @csrf
            <flux:input
                label="{{__('Responsable')}}"
                icon="user"
                name="responsable"
                value="{{ auth()->user()->name }}"
                readonly
            />
            <br>
            <flux:input
                label="{{ __('Nombre del Cliente') }}"
                icon="user-circle"
                badge="{{__('Obligatorio')}}"
                name="cliente"
                placeholder="Ingresa nombre del cliente"
                required
                autocomplete="off"
                autofocus=
                />
            <br>
            <flux:input
                label="{{ __('Nota de Venta')}}"
                icon="newspaper"
                badge="{{__('Obligatorio')}}"
                name="notaVenta"
                placeholder="Ingresa número de nota de venta"
                required
                autocomplete="off"
            />
            <br>

            <div class="flex">
                <flux:spacer />
                <br>
                <flux:button type="submit" variant="primary">
                    {{ __('Iniciar Separación') }}
                </flux:button>
            </div>
        </form>
    </div>
</flux:modal>

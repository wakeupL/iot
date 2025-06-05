<x-layouts.app :title="__('I.o.T. | Bodega')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        @if (session()->has('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif
        @if (session()->has('error'))
            <div class="text-red-600">{{ session('error') }}</div>
        @endif
        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="p-10 text-center text-md text-neutral-900 dark:text-neutral-100">
                <flux:heading size="xl">{{ __('Módulos de trabajos') }}</flux:heading>
            </div>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-3 text-center">
            <div
                class="lg:p-10 md:p-5 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

                <div class="overflow-hidden font-bold text-2xl text-neutral-900 dark:text-neutral-100">
                    {{ __('Ingresar Material') }}
                </div>

                <div class="lg:pt-5 md:pt-5 text-md font-semibold text-neutral-900 dark:text-neutral-100">
                    <flux:button variant="primary" :href="route('ingreso-material.index')" wire:navigate.hover
                        icon="plus-circle">
                        {{ __('INGRESAR MATERIAL') }}</flux:button>
                </div>
            </div>
            <div
                class="lg:p-10 md:p-5 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

                <x-separar-material />

            </div>
            <div
                class="lg:p-10 md:p-5 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class=" overflow-hidden font-bold text-2xl text-neutral-900 dark:text-neutral-100">
                    {{ __('Lista de Pedidos Separados') }}
                </div>

                <div class="lg:pt-10 md:pt-5 text-md font-semibold text-neutral-900 dark:text-neutral-100">
                    <flux:button variant="primary" :href="route('pedidos.index')" icon="numbered-list" wire:navigate.hover>
                        {{ __('PEDIDOS PREPARADOS') }}</flux:button>
                </div>
            </div>
            <div
                class="lg:p-10 md:p-5 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class=" overflow-hidden font-bold text-2xl text-neutral-900 dark:text-neutral-100">
                    {{ __('Pedido Listo para Despacho') }}
                </div>

                <div class="lg:pt-10 md:pt-5 text-md font-semibold text-neutral-900 dark:text-neutral-100">
                    <flux:button variant="primary" :href="route('dashboard')" icon="truck">
                        {{ __('DESPACHAR PEDIDO') }}</flux:button>
                </div>
            </div>
            <div
                class="lg:p-10 md:p-5 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class=" overflow-hidden font-bold text-2xl text-neutral-900 dark:text-neutral-100">
                    {{ __('Consultar Stock de Productos') }}
                </div>

                <div class="lg:pt-10 md:pt-5 text-md font-semibold text-neutral-900 dark:text-neutral-100">
                    <flux:button variant="primary" :href="route('productos.stock')" icon="square-3-stack-3d" wire:navigate.hover>
                        {{ __('CONSULTAR STOCK') }}</flux:button>
                </div>
            </div>
            <div
                class="lg:p-10 md:p-5 relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern
                    class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
                <div class=" overflow-hidden font-bold text-2xl text-neutral-900 dark:text-neutral-100">
                    {{ __('Entrega Inmediata') }}
                </div>

                <div class="lg:pt-10 md:pt-5 text-md font-semibold text-neutral-900 dark:text-neutral-100">
                    <flux:button variant="danger" :href="route('dashboard')" icon="chevron-double-right">
                        {{ __('CLIENTE RETIRA') }}</flux:button>
                </div>
            </div>
        </div>

    </div>
</x-layouts.app>

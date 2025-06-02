<x-layouts.app :title="__('I.o.T. | Bodega -> Separar Material')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            <div class="p-10 text-center text-md text-neutral-900 dark:text-neutral-100">
                <flux:heading size="xl">{{ __('Módulo de trabajo -> Separar Material') }}</flux:heading>
            </div>
        </div>
            <livewire:preparar-pedido :pedido-id="$id" />
    </div>
</x-layouts.app>

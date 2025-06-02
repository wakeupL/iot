<x-layouts.app :title="__('I.o.T. | Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid gap-4 md:grid-cols-3">
            <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />

                <div class="text-center justify-center p-4 text-md text-neutral-900 dark:text-neutral-100">
                    {{ __('¿Qué es I.o.T.?')}}
                    <br>
                    {{ __('I.o.T. son las sigas de Inventary, Orders and Tracking, es un sistema de gestión de inventario
                     y pedidos que permite a las empresas llevar un control eficiente de sus productos y pedidos. Con I.o.T.,
                    las empresas pueden gestionar su inventario en tiempo real, realizar un seguimiento de los
                    pedidos y optimizar su cadena de suministro.')}}
                </div>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts.app>

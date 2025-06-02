<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Apaciencia')" :subheading=" __('Actualice la configuración de apariencia de su cuenta')">
        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
            <flux:radio value="light" icon="sun">{{ __('Claro') }}</flux:radio>
            <flux:radio value="dark" icon="moon">{{ __('Oscuro') }}</flux:radio>
            <flux:radio value="system" icon="computer-desktop">{{ __('Sistema') }}</flux:radio>
        </flux:radio.group>
    </x-settings.layout>
</section>

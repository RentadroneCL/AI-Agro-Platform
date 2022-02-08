<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Inspection Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Provide the report details required for the inspection.') }}
    </x-slot>

    <x-slot name="form">
        <x-jet-input id="site_id" type="hidden" class="mt-1 block w-full" wire:model.defer="state.site_id" />

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="site_name" value="{{ __('Name, as it will appear on the report') }}" />
            <x-jet-input id="site_name" type="text" class="mt-1 block w-full" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="site_name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="commissioning_date" value="{{ __('Commissioning date') }}" />
            <x-jet-input id="commissioning_date" type="date" class="mt-1 block w-full" wire:model.defer="state.commissioning_date" />
            <x-jet-input-error for="commissioning_date" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        <x-jet-button wire:loading.attr="disabled" wire:click="update">
            {{ __('Save') }}
        </x-jet-button>
    </x-slot>
</x-jet-form-section>

<x-jet-form-section submit="update">
    <x-slot name="title">
        {{ __('Site Information') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Collect this information if you are requesting the first inspection of a new site.') }}
    </x-slot>

    <x-slot name="form">
        <x-jet-input id="user_id" type="hidden" class="block w-full mt-1" wire:model.defer="state.user_id" />

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="name" value="{{ __('Site name, as it will appear on the report') }}" />
            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" autocomplete="name" />
            <x-jet-input-error for="state.name" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="address" value="{{ __('Site address, as it will appear on the report') }}" />
            <x-jet-input id="address" type="text" class="block w-full mt-1" wire:model.defer="state.address" autocomplete="address" />
            <x-jet-input-error for="state.address" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="latitude" value="{{ __('Latitude, to at least 5 decimal places') }}" />
            <x-jet-input id="latitude" type="text" class="block w-full mt-1" wire:model.defer="state.latitude" />
            <x-jet-input-error for="state.latitude" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="longitude" value="{{ __('Longitude, to at least 5 decimal places') }}" />
            <x-jet-input id="longitude" type="text" class="block w-full mt-1" wire:model.defer="state.longitude" />
            <x-jet-input-error for="state.longitude" class="mt-2" />
        </div>

        <div class="col-span-6 sm:col-span-4">
            <x-jet-label for="commissioning_date" value="{{ __('Commissioning date') }}" />
            <x-jet-input id="commissioning_date" type="date" class="block w-full mt-1" wire:model.defer="state.commissioning_date" />
            <x-jet-input-error for="state.commissioning_date" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="saved">
            {{ __('Saved.') }}
        </x-jet-action-message>

        @if (Auth::user()->hasRole('administrator'))
            <x-jet-button wire:loading.attr="disabled" wire:click="update">
                {{ __('Save') }}
            </x-jet-button>
        @endif
    </x-slot>
</x-jet-form-section>

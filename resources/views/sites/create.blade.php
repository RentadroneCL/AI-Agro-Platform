<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Solar Site') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('create-site-form')
            {{-- <x-jet-form-section submit="{{ route('site.store') }}">
                <x-slot name="title">
                    {{ __('Site information') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('Collect this information if you are requesting the first inspection of a new site.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="site_name" value="{{ __('Site name, as it will appear on the report') }}" />
                        <x-jet-input id="site_name" type="text" class="mt-1 block w-full" wire:model.defer="state.current_password" autocomplete="current-password" />
                        <x-jet-input-error for="site_name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="site_address" value="{{ __('Site address, as it will appear on the report') }}" />
                        <x-jet-input id="site_address" type="text" class="mt-1 block w-full" wire:model.defer="state.password" autocomplete="new-password" />
                        <x-jet-input-error for="site_address" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="latitude" value="{{ __('Latitude, to at least 5 decimal places') }}" />
                        <x-jet-input id="latitude" type="text" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                        <x-jet-input-error for="latitude" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="longitude" value="{{ __('Longitude, to at least 5 decimal places') }}" />
                        <x-jet-input id="longitude" type="text" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                        <x-jet-input-error for="longitude" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="commissioning_date" value="{{ __('Commissioning date') }}" />
                        <x-jet-input id="commissioning_date" type="date" class="mt-1 block w-full" wire:model.defer="state.password_confirmation" autocomplete="new-password" />
                        <x-jet-input-error for="commissioning_date" class="mt-2" />
                    </div>
                </x-slot>

                <x-slot name="actions">
                    <x-jet-action-message class="mr-3" on="saved">
                        {{ __('Saved.') }}
                    </x-jet-action-message>

                    <x-jet-button>
                        {{ __('Save') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-form-section> --}}
        </div>
    </div>
</x-app-layout>

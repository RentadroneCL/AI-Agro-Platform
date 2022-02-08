<div class="mb-4 sm:mb-0">
    <x-jet-button wire:click="$toggle('confirmingSiteCreation')" wire:loading.attr="disabled">
        {{ __('New Site') }}
    </x-jet-button>

    <!-- Create new inspection Modal -->
    <x-jet-dialog-modal maxWidth="2xl" wire:model="confirmingSiteCreation">
        <x-slot name="title">
            {{ __('New Site') }}
        </x-slot>

        <x-slot name="content">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium text-gray-900">{{ __('Site information') }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ __('Collect this information if you are requesting the first inspection of a new site.') }}</p>
                    </div>
                </div>

                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="px-4 py-5 sm:p-6">
                        <x-jet-input id="user_id" type="hidden" class="block w-full mt-1" wire:model.defer="state.user_id" />

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="name" value="{{ __('Site name, as it will appear on the report') }}" />
                            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.defer="state.name" autocomplete="name" />
                            <x-jet-input-error for="state.name" class="mt-2" />
                        </div>

                        <div class="col-span-6 my-2 sm:col-span-4">
                            <x-jet-label for="address" value="{{ __('Site address, as it will appear on the report') }}" />
                            <x-jet-input id="address" type="text" class="block w-full mt-1" wire:model.defer="state.address" autocomplete="address" />
                            <x-jet-input-error for="state.address" class="mt-2" />
                        </div>

                        <div class="col-span-6 my-2 sm:col-span-4">
                            <x-jet-label for="latitude" value="{{ __('Latitude, to at least 5 decimal places') }}" />
                            <x-jet-input id="latitude" type="text" class="block w-full mt-1" wire:model.defer="state.latitude" />
                            <x-jet-input-error for="state.latitude" class="mt-2" />
                        </div>

                        <div class="col-span-6 my-2 sm:col-span-4">
                            <x-jet-label for="longitude" value="{{ __('Longitude, to at least 5 decimal places') }}" />
                            <x-jet-input id="longitude" type="text" class="block w-full mt-1" wire:model.defer="state.longitude" />
                            <x-jet-input-error for="state.longitude" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-4">
                            <x-jet-label for="commissioning_date" value="{{ __('Commissioning date') }}" />
                            <x-jet-input id="commissioning_date" type="date" class="block w-full mt-1" wire:model.defer="state.commissioning_date" />
                            <x-jet-input-error for="state.commissioning_date" class="mt-2" />
                        </div>
                    </div>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingSiteCreation')" wire:loading.attr="disabled">
                {{ __('Neverminds') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
                {{ __('Create Site') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

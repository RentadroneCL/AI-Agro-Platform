<div x-data x-show='$wire.displayPanelCreationForm' class="px-4 py-2 sm:px-6">
  <div class="max-w-md p-4 text-white bg-blue-500 rounded-md shadow">
    <h3 class="inline-flex items-center mb-2 text-lg font-semibold">
      <i class="mr-4 fas fa-info-circle fa-fw"></i> {{ __('Sync panel information') }}
    </h3>
    <div>
      {{ __('The current selection is not fulfilled in the database please fill up the input data to complete the process.') }}
    </div>
  </div>
  <form wire:submit.prevent='store' id="panel-sync-form" class="my-2">
    <x-jet-input id="site_id" type="hidden" class="block w-full mt-1" wire:model.defer="state.site_id" />
    <div class="my-2">
      <x-jet-label for="panel_id" value="{{ __('Panel') }}" />
      <x-jet-input disabled id="panel_id" type="text" class="block w-full mt-1 bg-gray-50" wire:model.defer="state.panel_id" />
      <x-jet-input-error for="state.panel_id" class="mt-2" />
    </div>

    <div class="my-2">
      <x-jet-label for="panel_serial" value="{{ __('Serial') }}" />
      <x-jet-input id="panel_serial" type="text" class="block w-full mt-1" wire:model.defer="state.panel_serial" />
      <x-jet-input-error for="state.panel_serial" class="mt-2" />
    </div>

    <div class="my-2">
      <x-jet-label for="panel_zone" value="{{ __('Panel Zone') }}" />
      <x-jet-input disabled id="panel_zone" type="text" class="block w-full mt-1 bg-gray-50" wire:model.defer="state.panel_zone" />
      <x-jet-input-error for="state.panel_zone" class="mt-2" />
    </div>

    <div class="my-2">
      <x-jet-label for="panel_sub_zone" value="{{ __('Panel Sub Zone') }}" />
      <x-jet-input disabled id="panel_sub_zone" type="text" class="block w-full mt-1 bg-gray-50" wire:model.defer="state.panel_sub_zone" />
      <x-jet-input-error for="state.panel_sub_zone" class="mt-2" />
    </div>

    <div class="my-2">
      <x-jet-label for="panel_string" value="{{ __('Panel String') }}" />
      <x-jet-input disabled id="panel_string" type="text" class="block w-full mt-1 bg-gray-50" wire:model.defer="state.panel_string" />
      <x-jet-input-error for="state.panel_string" class="mt-2" />
    </div>

    <div class="inline-flex items-center justify-between w-full mt-3">
      <x-jet-button>
        {{ __('Sync panel information') }}
      </x-jet-button>

      <x-jet-action-message class="mr-3" on="saved">
        {{ __('Saved.') }}
      </x-jet-action-message>
    </div>
  </form>
</div>

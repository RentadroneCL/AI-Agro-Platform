<x-jet-action-section>
    <x-slot name="title">
        {{ $site->name }}
    </x-slot>

    <x-slot name="description">
        {{ $site->inspections->count() }} {{ __('Inspections') }}
    </x-slot>

    <x-slot name="content">
        <div class="flex flex-col md:flex-row items-center justify-start md:justify-between max-w-xl text-sm text-gray-600">
            <div class="flex flex-col items-center justify-start">
                @forelse ($site->inspections->take(5) as $inspection)
                    <x-jet-nav-link href="{{ route('inspection.show', $inspection) }}" >
                        {{ $inspection->name }}
                    </x-jet-nav-link>
                @empty
                    <x-button-link href="{{ route('site.show', $site) }}">
                        {{ __('Create new inspection') }}
                    </x-button-link>
                @endforelse
            </div>

            <!-- Actions Dropdown -->
            <div class="ml-3 relative">
                <x-jet-dropdown align="right" width="60">
                    <x-slot name="trigger">
                        <span class="inline-flex rounded-md">
                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                {{ __('Action') }}

                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </span>
                    </x-slot>

                    <x-slot name="content">
                        <div class="w-60">
                            <!-- Team Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Site') }}
                            </div>

                            <!-- Site Settings -->
                            <x-jet-dropdown-link href="{{ route('site.show', $site->id) }}">
                                {{ __('Site Settings') }}
                            </x-jet-dropdown-link>

                            <x-jet-dropdown-link wire:click="confirmInspectionCreation" wire:loading.attr="disabled">
                                {{ __('Create New Inspection') }}
                            </x-jet-dropdown-link>
                        </div>
                    </x-slot>
                </x-jet-dropdown>
            </div>

            <!-- Create New Site Modal -->
            <x-jet-dialog-modal wire:model='"confirmingInspectionCreation'>
                <x-slot name="title">
                    Create New Site
                </x-slot>

                <x-slot name="content">
                    @livewire('create-inspection-form', ['site' => $site], key($site->id))
                </x-slot>

                <x-slot name="footer">
                    <x-jet-secondary-button wire:click="$toggle('confirmingInspectionCreation')" wire:loading.attr="disabled">
                        {{ __('Nevermind') }}
                    </x-jet-secondary-button>

                    <x-jet-button class="ml-2" wire:click="store" wire:loading.attr="disabled">
                        {{ __('Create New Inspection') }}
                    </x-jet-button>
                </x-slot>
            </x-jet-dialog-modal>
        </div>
    </x-slot>
</x-jet-action-section>

<x-jet-action-section>
    <x-slot name="title">
        {{ __('Delete Site') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete this site.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            {{ __('Once this site is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <x-jet-danger-button wire:click="confirmSiteDeletion" wire:loading.attr="disabled">
                {{ __('Delete Site') }}
            </x-jet-danger-button>
        </div>

        <!-- Delete Site Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingSiteDeletion">
            <x-slot name="title">
                {{ __('Delete Site') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete this site? Once this site is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-site.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="mt-1 block w-3/4"
                                placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="destroy" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingSiteDeletion')" wire:loading.attr="disabled">
                    {{ __('Nevermind') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="destroy" wire:loading.attr="disabled">
                    {{ __('Delete Site') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>

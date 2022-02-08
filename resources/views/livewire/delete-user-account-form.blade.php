<x-jet-action-section>
    <x-slot name="title">
        {{ __('Deactivate user account') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Permanently delete the account.') }}
    </x-slot>

    <x-slot name="content">
        <p class="max-w-xl text-sm text-gray-600">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <div class="mt-5">
            <x-jet-danger-button wire:click="confirmUserAccountDeletion" wire:loading.attr="disabled">{{ __('Delete Account') }}</x-jet-danger-button>
        </div>

        <!-- Delete User account Confirmation Modal -->
        <x-jet-dialog-modal wire:model="confirmingUserAccountDeletion">
            <x-slot name="title">
                {{ __('Delete Account') }}
            </x-slot>

            <x-slot name="content">
                {{ __('Are you sure you want to delete the account? Once the account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete the account.') }}

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-jet-input type="password" class="block w-3/4 mt-1"
                                placeholder="{{ __('Password') }}"
                                x-ref="password"
                                wire:model.defer="password"
                                wire:keydown.enter="destroy" />

                    <x-jet-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-jet-secondary-button wire:click="$toggle('confirmingUserAccountDeletion')" wire:loading.attr="disabled">
                    {{ __('Cancel') }}
                </x-jet-secondary-button>

                <x-jet-danger-button class="ml-2" wire:click="destroy({{ $user->id }})" wire:loading.attr="disabled">
                    {{ __('Delete Account') }}
                </x-jet-danger-button>
            </x-slot>
        </x-jet-dialog-modal>
    </x-slot>
</x-jet-action-section>

<div>
    <span class="inline-flex rounded-md">
        <button wire:click="$toggle('confirmingContactFormSubmission')" type="button" class="inline-flex items-center px-3 py-2 mr-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
            <i class="fas fa-headset fa-fw fa-lg"></i>
        </button>
    </span>

    <x-jet-dialog-modal wire:model="confirmingContactFormSubmission">
        <x-slot name="title">
            {{ __('Have a question? Send us a note using the form below and someone from the droneraising team will be in touch soon.') }}
        </x-slot>

        <x-slot name="content">
            <div class="col-span-6 mb-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.lazy="state.name" autocomplete="name" required />
                <x-jet-input-error for="state.name" class="mt-2" />
            </div>

            <div class="col-span-6 mb-4">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" type="email" class="block w-full mt-1" wire:model.lazy="state.email" autocomplete="email" required />
                <x-jet-input-error for="state.email" class="mt-2" />
            </div>

            <div class="col-span-6 mb-4">
                <x-jet-label for="phone" value="{{ __('Contact Phone') }}" />
                <x-jet-input id="phone" type="tel" class="block w-full mt-1" wire:model.lazy="state.phone" autocomplete="phone" required />
                <x-jet-input-error for="state.phone" class="mt-2" />
            </div>

            <div class="col-span-6 mb-4">
                <x-jet-label for="type" value="{{ __('Reason for getting in touch') }}" />
                <select wire:model.lazy="state.type" id="type" name="type" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="">{{ __('Reason for getting in touch') }}</option>
                    <option value="Account / Control Panel">Account / Control Panel</option>
                    <option value="Billing">Billing</option>
                    <option value="Something is not working">Something Is Not Working</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="col-span-6 mb-4">
                <x-jet-label for="subject" value="{{ __('Subject') }}" />
                <x-jet-input id="subject" type="text" class="block w-full mt-1" wire:model.lazy="state.subject" autocomplete="subject" />
                <x-jet-input-error for="state.subject" class="mt-2" />
            </div>

            <div class="col-span-6 mb-4">
                <x-jet-label for="message" value="{{ __('Message') }}" />
                <textarea wire:model.lazy="state.message" id="message" name="message" rows="3" placeholder="{{ __('Brief description of how can help you') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" spellcheck="false"></textarea>
                <x-jet-input-error for="state.message" class="mt-2" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('confirmingContactFormSubmission')" wire:loading.attr="disabled">
                {{ __('Nevermind') }}
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="sendMessage" wire:loading.attr="disabled">
                {{ __('Send Message') }}
            </x-jet-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>

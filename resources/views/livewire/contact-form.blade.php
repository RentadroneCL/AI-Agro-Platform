<x-jet-form-section submit="sendMessage">
    <x-slot name="title">{{ __('Get in touch') }}</x-slot>

    <x-slot name="description">{{ __('Have a question? Send us a note using the form below and someone from the droneraising team will be in touch soon.') }}</x-slot>

    <x-slot name="form">
        <div class="col-span-6">
            <x-jet-label for="name" value="{{ __('Name') }}" />
            <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.lazy="state.name" autocomplete="name" required />
            <x-jet-input-error for="state.name" class="mt-2" />
        </div>

        <div class="col-span-6">
            <x-jet-label for="email" value="{{ __('Email') }}" />
            <x-jet-input id="email" type="email" class="block w-full mt-1" wire:model.lazy="state.email" autocomplete="email" required />
            <x-jet-input-error for="state.email" class="mt-2" />
        </div>

        <div class="col-span-6">
            <x-jet-label for="phone" value="{{ __('Contact Phone') }}" />
            <x-jet-input id="phone" type="tel" class="block w-full mt-1" wire:model.lazy="state.phone" autocomplete="phone" required />
            <x-jet-input-error for="state.phone" class="mt-2" />
        </div>

        <div class="col-span-6">
            <x-jet-label for="type" value="{{ __('Reason for getting in touch') }}" />
            <select wire:model.lazy="state.type" id="type" name="type" required class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="">{{ __('Reason for getting in touch') }}</option>
                <option value="Account / Control Panel">Account / Control Panel</option>
                <option value="Billing">Billing</option>
                <option value="Something is not working">Something Is Not Working</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <div class="col-span-6">
            <x-jet-label for="subject" value="{{ __('Subject') }}" />
            <x-jet-input id="subject" type="text" class="block w-full mt-1" wire:model.lazy="state.subject" autocomplete="subject" />
            <x-jet-input-error for="state.subject" class="mt-2" />
        </div>

        <div class="col-span-6">
            <x-jet-label for="message" value="{{ __('Message') }}" />
            <textarea wire:model.lazy="state.message" id="message" name="message" rows="3" placeholder="{{ __('Brief description of how can help you') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" spellcheck="false"></textarea>
            <x-jet-input-error for="state.message" class="mt-2" />
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-jet-action-message class="mr-3" on="sent">
            {{ __('Notification sent!') }}
        </x-jet-action-message>

        <x-jet-button>{{ __('Send message') }}</x-jet-button>
    </x-slot>
</x-jet-form-section>

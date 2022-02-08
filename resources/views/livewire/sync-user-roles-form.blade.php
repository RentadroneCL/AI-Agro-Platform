<div>
    <x-jet-form-section submit="update">>
        <x-slot name="title">
            {{ __('Attach or detach the user\'s roles') }}
        </x-slot>

        <x-slot name="description">
            {{ __('Each user has a role by default which has a set of permissions or policies such as viewing an administrator dashboard or create resources.') }}
        </x-slot>

        <x-slot name="form">
            @foreach ($roles as $role)
                <div class="inline-flex items-center">
                    <input wire:model.defer="state.roles" value="{{ $role->id }}" type="checkbox" class="text-blue-600 border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <span class="ml-2 text-base text-gray-600">{{ Str::title($role->name) }}</span>
                </div>
            @endforeach
        </x-slot>

        <x-slot name="actions">
            <x-jet-action-message class="mr-3" on="saved">
                {{ __('Saved.') }}
            </x-jet-action-message>

            <x-jet-button>
                {{ __('Save') }}
            </x-jet-button>
        </x-slot>
    </x-jet-form-section>
</div>

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <livewire:update-user-information-form :user="$user">

        <x-jet-section-border></x-jet-section-border>

        <livewire:user-sites-management :user="$user">

        <x-jet-section-border></x-jet-section-border>

        @if (! is_null($user->onboarding))
            <livewire:onboarding-management :user="$user">
            <x-jet-section-border></x-jet-section-border>
        @endif

        <livewire:sync-user-roles-form :user="$user">

        <x-jet-section-border></x-jet-section-border>

        <x-jet-action-section>
            <x-slot name="title">
                {{ __('Reset user password') }}
            </x-slot>

            <x-slot name="description">
                {{ __('Handles emailing links for resetting password.') }}
            </x-slot>

            <x-slot name="content">
                <div class="max-w-xl text-sm text-gray-600">
                    {{ __('Reset the password once the user clicks on the password reset link that has been emailed to them and provides a new password.') }}
                </div>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="block">
                        <x-jet-input id="email" class="block w-full mt-1" type="hidden" name="email" value="{{ $user->email }}" required />
                    </div>

                    <div class="flex items-center mt-4">
                        <x-jet-button>
                            {{ __('Send reset password e-mail link') }}
                        </x-jet-button>
                    </div>
                </form>
            </x-slot>
        </x-jet-action-section>

        <x-jet-section-border></x-jet-section-border>

        <livewire:delete-user-account-form :user="$user">
    </div>
</x-app-layout>

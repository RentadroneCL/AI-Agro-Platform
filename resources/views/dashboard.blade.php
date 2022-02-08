<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if (!Auth::user()->onboarding && !Auth::user()->hasRole('administrator'))
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <livewire:onboarding>
            </div>
        </div>
    @else
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                @forelse ($sites as $site)
                    <livewire:site-card :site="$site">
                @empty
                    <div class="col-span-3 px-4 py-5 bg-white shadow sm:p-6 sm:rounded-lg">
                        <div class="max-w-xl text-sm text-gray-600">
                            <div class="flex flex-row items-center">
                                <i class="mr-4 text-gray-400 fas fa-database"></i>
                                <p>{{ __('No entries found.') }}</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    @endif
</x-app-layout>

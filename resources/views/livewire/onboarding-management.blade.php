<x-jet-action-section>
    <x-slot name="title">
        {{ __('Onboarding process') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Summary page.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            <div x-data x-show="$wire.completed" class="flex flex-row items-center justify-start p-4 mb-5 bg-green-100 rounded-md shadow-sm">
                <i class="mr-4 text-green-400 fas fa-check-circle fa-fw"></i>
                <span class="font-semibold tracking-wider text-green-800">{{ __('Onboarding completed.') }}</span>
            </div>

            <div class="overflow-y-auto scrolling-touch rounded-md scrollbar-w-2 scrollbar-track-gray-lighter scrollbar-thumb-rounded scrollbar-thumb-gray">
                <table class="w-full text-left border border-collapse">
                    <tbody class="align-baseline">
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-gray-800 border-b whitespace-nowrap bg-gray-50">
                                {{ __('Name') }}
                            </th>
                            <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">{{ $user->onboarding->name }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-gray-800 border-b whitespace-nowrap bg-gray-50">
                                {{ __('Position') }}
                            </th>
                            <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">{{ $user->onboarding->position }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-gray-800 border-b whitespace-nowrap bg-gray-50">
                                {{ __('Address') }}
                            </th>
                            <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">{{ $user->onboarding->address }}</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-gray-800 border-b whitespace-nowrap bg-gray-50">
                                {{ __('Installed Capacity') }}
                            </th>
                            <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">{{ $user->onboarding->installed_capacity }} MWp.</td>
                        </tr>
                        <tr>
                            <th class="px-4 py-3 text-sm font-medium text-gray-800 whitespace-nowrap bg-gray-50">
                                {{ __('Message') }}
                            </th>
                            <td class="px-4 py-3 text-sm text-gray-600 whitespace-nowrap">{{ $user->onboarding->message ?? 'N/A' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        @if ($user->onboarding->getMedia('attachments')->count())
            <div class="flex flex-col items-center justify-start mt-5 border border-gray-200 divide-y divide-gray-200 rounded-md shadow-sm">
                @foreach ($user->onboarding->getMedia('attachments') as $attachment)
                    <a class="flex flex-row items-center justify-start w-full p-4 text-xs text-gray-600 hover:bg-gray-50" href="{{ $attachment->getFullUrl() }}" download>
                        <i class="mr-4 text-gray-400 fas fa-paperclip fa-fw"></i>
                        <span class="font-medium">{{ $attachment->file_name }}</span>
                    </a>
                @endforeach
            </div>

            {{-- <div class="w-full mt-3 text-right">
                <x-jet-secondary-button>{{ __('Download all') }}</x-jet-secondary-button>
            </div> --}}
        @else
            <div class="flex flex-row items-center max-w-xl p-4 mt-5 rounded-md shadow-sm bg-gray-50">
                <i class="mr-4 text-gray-400 fas fa-paperclip fa-fw"></i>
                <p class="text-gray-600">{{ __('No attachments found.') }}</p>
            </div>
        @endif

        <div x-data x-show="$wire.completed === false" class="mt-5">
            <x-jet-button wire:model="completed" wire:click="markAsCompleted">{{ __('Mark as completed') }}</x-jet-button>
        </div>
    </x-slot>
</x-jet-action-section>

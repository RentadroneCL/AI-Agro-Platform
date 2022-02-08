<div>
    <nav class="flex flex-col items-center justify-start border border-gray-200 divide-y divide-gray-200 rounded-md">
        @forelse ($sites as $site)
            <a class="flex flex-row items-center justify-start w-full p-4 text-gray-600 hover:bg-gray-50" href="{{ route('site.show', $site) }}">
                <h3 class="font-semibold">{{ $site->name }}</h3>

                <span class="hidden ml-auto mr-4 sm:block">
                    <i class="text-gray-400 fas fa-chevron-right fa-fw"></i>
                </span>
            </a>
        @empty
            <div class="flex flex-row items-center py-6 text-lg font-normal text-gray-600 md:py-8">
                <i class="mr-4 text-gray-400 fas fa-database fa-fw fa-lg"></i> {{ __('No records found.') }}
            </div>
        @endforelse
    </nav>

    <div class="px-4 py-2">
        {{ $sites->links() }}
    </div>
</div>

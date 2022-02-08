<div>
  @if ($files->count())
    <div x-data="{ report: '{{ Storage::temporaryUrl($files->first()->getPath(), Carbon::now()->addMinutes(60)) }}' }" class="bg-white">
      <div class="md:grid md:grid-cols-3 md:gap-0">
        <div class="md:col-span-1 md:border-r md:border-gray-200">
          <div class="px-4 py-5">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Report Viewer') }}</h3>
            <p class="mt-1 text-sm text-gray-600">{{ __('Records') }} {{ $files->count() }}</p>
          </div>
          <div class="border-gray-200">
            <ul>
              @foreach ($files as $file)
                <li @click="report = '{{ Storage::temporaryUrl($file->getPath(), Carbon::now()->addMinutes(60)) }}'" class="block py-2 pl-3 pr-4 text-base font-medium text-gray-600 transition duration-150 ease-in-out border-l-4 border-transparent cursor-pointer hover:text-gray-800 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:text-gray-800 focus:bg-gray-50 focus:border-gray-300">{{ $file->name }}</li>
              @endforeach
            </ul>
          </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
          <object x-bind:data="report" type="application/pdf" class="w-full h-screen">
            <p class="px-4 py-5 mb-4 text-sm text-gray-600 hover:text-gray-700 hover:underline">
              {{ __('To view this file please enable JavaScript, and consider upgrading to a recent version of your web browser.') }}
            </p>
            <x-button-link x-bind:href="report">
              {{ __('Download') }}
            </x-button-link>
          </object>
        </div>
      </div>
    </div>
  @else
    <div class="max-w-2xl px-4 py-5 mx-auto mt-8 bg-white shadow sm:p-6 sm:rounded-lg">
      <h3 class="text-lg font-medium text-gray-900">{{ __('The report files are NOT uploaded yet.') }}</h3>
      <div class="max-w-xl mt-3 text-sm text-gray-600">
        <p>{{ __('Go to the Files management tab and upload all the data related to this inspection.') }}</p>
      </div>
    </div>
  @endif
</div>

<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      <x-jet-nav-link class="text-xl font-semibold leading-tight" href="{{ route('site.show', $inspection->site) }}">
        {{ $inspection->site->name }}
      </x-jet-nav-link>
        <small class="ml-4 text-xs text-gray-600">{{ $inspection->name }} {{ __($inspection->commissioning_date->toFormattedDateString()) }}</small>
      </h2>
  </x-slot>

  @if (Auth::user()->hasRole('administrator'))
    <div class="flex items-center p-4 text-sm font-medium text-white bg-blue-500 shadow-sm">
      <div class="p-2 mr-2 bg-blue-600 rounded-full">
        <i class="fas fa-info-circle fa-fw"></i>
      </div>
      <p>
        {{ __('You are impersonating') }} <a class="font-semibold underline" href={{ route('user.edit', $inspection->site->user) }}>{{ $inspection->site->user->name }}</a>
      </p>
    </div>
  @endif

  <div x-data="{ tab: '#map' }">
    <nav class="bg-gray-200 border-b-2 border-gray-300">
      <div class="px-4 max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-full md:h-16">
          <div class="flex flex-col md:flex-row">
            <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out border-b-2 cursor-pointer hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300" :class="{'text-gray-700 border-blue-400 border-b-2 font-semibold': tab === '#map'}" @click="tab = '#map'">
                {{ __('Map') }}
              </a>
            </div>

            <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out border-b-2 cursor-pointer hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300" :class="{'text-gray-700 border-blue-400 border-b-2 font-semibold': tab === '#files'}" @click="tab = '#files'">
                {{ __('Files') }}
              </a>
            </div>

            <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
              <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out border-b-2 cursor-pointer hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300" :class="{'text-gray-700 border-blue-400 border-b-2 font-semibold': tab === '#reports'}" @click="tab = '#reports'">
                {{ __('Reports') }}
              </a>
            </div>

            @if (Auth::user()->hasRole('administrator'))
              <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
                <a class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out border-b-2 cursor-pointer hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300" :class="{'text-gray-700 border-blue-400 border-b-2 font-semibold': tab === '#settings'}" @click="tab = '#settings'">
                  {{ __('Settings') }}
                </a>
              </div>
            @endif
          </div>
        </div>
      </div>
    </nav>

    <div x-show="tab === '#map'" @cloak>
      <div class="max-w-full px-6 mx-auto md:px-0">
        <livewire:map-viewer :model="$inspection" :files="$inspection->getMedia('orthomosaic-geojson')">
      </div>
    </div>

    <div x-show="tab === '#files'" @cloak>
      <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">

        @if (Auth::user()->hasRole('administrator'))
          <x-jet-action-section>
            <x-slot name="title">
              {{ __('File Management') }}
            </x-slot>

            <x-slot name="description">
              {{ __('Click the upload file button from the right toolbar and add your images from their destination folder, or directly drag them into the upload box.') }}
            </x-slot>

            <x-slot name="content">
              <livewire:upload-files :inspection="$inspection">


              <div class="max-w-xl mt-3 text-sm text-gray-600">
                <p class="mb-1">{{ __('If you are uploading data to enable creation of an Orthomosaic, use Orthomosaic/GeoJSON as the file type.') }}</p>
              </div>

              <div class="max-w-xl mt-3 text-xs text-gray-600">
                <p>{{ __('Limit each upload session to a maximum of 200 files.') }}</p>
                <p>{{ __('The maximum file size session allowed is 900MB.') }}</p>
                <p>{{ __('File Support: jpg, jpeg, tif, shp, pdf.') }}</p>
              </div>
            </x-slot>
          </x-jet-action-section>

          <x-jet-section-border></x-jet-section-border>
        @endif

        <livewire:files-table :model="$inspection">
      </div>
    </div>

    <div x-show="tab === '#reports'" @cloak>
      <div class="max-w-full mx-auto">
        <livewire:report-viewer :model="$inspection" :files="$inspection->getMedia('pdf')">
      </div>
    </div>

    @if (Auth::user()->hasRole('administrator'))
      <div x-show="tab === '#settings'" @cloak>
        <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
          <livewire:update-inspection-information-form :inspection="$inspection">

          <x-jet-section-border></x-jet-section-border>

          <livewire:delete-inspection-form :inspection="$inspection">
        </div>
      </div>
    @endif
  </div>
</x-app-layout>

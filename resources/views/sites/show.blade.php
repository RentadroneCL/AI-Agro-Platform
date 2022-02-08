<x-app-layout>
  <x-slot name="header">
    <h2 class="text-xl font-semibold leading-tight text-gray-800">
      {{ $site->name }} <small class="ml-4 text-xs text-gray-600">{{ $site->inspections->count() }} {{ __('Inspections') }}</small>
    </h2>
  </x-slot>

  @if (Auth::user()->hasRole('administrator'))
    <div class="flex items-center p-4 text-sm font-medium text-white bg-blue-500 shadow-sm">
      <div class="p-2 mr-2 bg-blue-600 rounded-full">
        <i class="fas fa-info-circle fa-fw"></i>
      </div>
      <p>
        {{ __('You are impersonating') }} <a class="font-semibold underline" href={{ route('user.edit', $site->user) }}>{{ $site->user->name }}</a>
      </p>
    </div>
  @endif

  <div class="py-10 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <x-jet-action-section>
      <x-slot name="title">{{ __('Site Inspections') }}</x-slot>

      <x-slot name="description">{{ __('All the inspections related to this site.') }}</x-slot>

      <x-slot name="content">
        @if (Auth::user()->hasRole('administrator'))
          <div class="mb-5">
            <livewire:new-inspection-modal-dialog :site="$site">
          </div>
        @endif

        <livewire:inspections-table :site="$site">
      </x-slot>
    </x-jet-action-section>

    <x-jet-section-border></x-jet-section-border>

    <livewire:update-site-information-form :site="$site">

    <x-jet-section-border></x-jet-section-border>

    <x-jet-action-section>
      <x-slot name="title">{{ __('Site Overview') }}</x-slot>

      <x-slot name="description">{{ __('Coordinates of the site location.') }}</x-slot>

      <x-slot name="content">
        <div id="map-container" class="shadow h-96 sm:rounded-lg sm:-m-6"></div>
      </x-slot>
    </x-jet-action-section>

    @if (Auth::user()->hasRole('administrator'))
      <x-jet-section-border></x-jet-section-border>
      <livewire:delete-site-form :site="$site">
    @endif

    <script>
      document.addEventListener('livewire:load', () => {
        new ol.Map({
          target: 'map-container',
          layers: [
            new TileLayer({
              source: new XYZ({
                url: 'https://mt{0-3}.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}',
              })
            }),
          ],
          view: new ol.View({
            center: fromLonLat([{{ $site->longitude }}, {{ $site->latitude }}]),
            zoom: 18,
          }),
        });
      });
    </script>
  </div>
</x-app-layout>

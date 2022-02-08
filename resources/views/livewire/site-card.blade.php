<div class="mt-5 md:mt-0 md:col-span-1">
  <div class="h-full bg-white shadow sm:rounded-lg">
    <div id="map-container-{{ $site->id }}" class="w-full sm:rounded-t-lg h-52"></div>
    <div class="px-4 py-5 sm:p-6">
      <h3 class="text-lg font-medium text-gray-900">{{ $site->name }}</h3>
      <div class="h-auto max-w-xl mt-3 text-sm text-gray-600">
        <p class="mb-2 font-semibold">{{ __('Most recent inspection') }}</p>

        @if ($site->inspections->count())
          <ul>
            @foreach ($site->inspections()->latest()->get()->take(5) as $inspection)
              <li>
                <x-jet-nav-link href="{{ route('inspection.show', $inspection) }}">{{ $inspection->name }}</x-jet-nav-link>
              </li>
            @endforeach
          </ul>
        @else
          <p>{{ __('There\'s no inspection yet!') }}</p>
        @endif
      </div>
      <div class="flex justify-end mt-auto">
        <x-jet-dropdown>
          <x-slot name="trigger">
            <span class="inline-flex rounded-md">
              <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                {{ __('Action') }} <i class="fas fa-angle-down fa-fw ml-2 -mr-0.5 h-4 w-4 text-gray-400"></i>
              </button>
            </span>
          </x-slot>

          <x-slot name="content">
            <div class="w-auto">
              <div class="block px-4 py-2 text-xs text-gray-400">{{ __('Manage Site') }}</div>
              <x-jet-dropdown-link href="{{ route('site.show', $site) }}">{{ __('Site Settings') }}</x-jet-dropdown-link>
            </div>
          </x-slot>
        </x-jet-dropdown>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('livewire:load', () => {
      const mouseWheellZoomInteraction = new MouseWheelZoom();
      mouseWheellZoomInteraction.active = false;

      new ol.Map({
        target: 'map-container-{{ $site->id }}',
        layers: [
          new TileLayer({
            source: new XYZ({
              url: 'https://mt{0-3}.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}' // 'https://mt{0-3}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}'
            })
          }),
        ],
        view: new ol.View({
          center: fromLonLat([{{ $site->longitude }}, {{ $site->latitude }}]),
          zoom: 18,
        }),
        controls: defaults({
          zoom: false,
        }),
        interactions: [
          mouseWheellZoomInteraction,
        ]
      });
    });
  </script>
</div>

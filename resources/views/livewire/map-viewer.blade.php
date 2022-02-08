<div>
  @if ($files)
    <div class="h-full bg-white">
      <div class="flex flex-col md:flex-row">
        <div class="w-full md:w-1/5 md:border-r md:border-gray-200">
          <div class="px-4 py-5">
            <h3 class="text-lg font-medium text-gray-900">{{ __('Map Viewer') }}</h3>
            <p class="mt-1 text-sm text-gray-600">{{ __('This view allows you to navigate a geospatial web map of your solar report.') }}</p>
          </div>

          <div class="flex flex-col items-center justify-center p-4" x-data="{ open: true }">
            <button @click="open = !open" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
              {{ __('Layers') }} <i class="ml-auto text-gray-400 fas fa-fw" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
            </button>

            <div class="w-full transition-all duration-700" x-show="open">
              <div class="overflow-y-auto overscroll-auto h-96">
                <ul class="list-none">
                  {{-- Geotiff layers --}}
                  @if (count($files['geotiff']))
                    @foreach ($files['geotiff'] as $file)
                      <li x-data="layer()" :class="{ 'text-gray-700 bg-gray-50': checked }" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-gray-600 transition duration-150 ease-in-out cursor-pointer hover:text-gray-700 hover:bg-gray-50 focus:outline-none focus:text-gray-700 focus:bg-gray-50">
                        <i class="mr-2 fas fa-fw" :class="{ 'fa-eye-slash': !checked, 'fa-eye text-blue-600': checked }"></i>
                        <input @click="activate({ type: 'geotiff', id: {{ $file->id }}, url: '{{ Storage::temporaryUrl($file->getPath(), Carbon::now()->addMinutes(60)) }}' })" id="{{ $file->id }}" type="checkbox" class="mr-2 text-blue-600 border-gray-300 rounded shadow-sm cursor-pointer focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"> {{ $file->name }}
                        <i id="spinner-{{ $file->id }}" class="hidden ml-auto text-blue-600 fas fa-sync-alt fa-fw fa-spin" title="{{ __('Fetching data') }}"></i>
                      </li>
                    @endforeach
                  @endif

                  {{-- GeoJSON Layers --}}
                  @if (count($files['geojson']))
                    @foreach ($files['geojson'] as $file)
                      <li x-data="layer()" :class="{ 'text-gray-700 bg-gray-50': checked }" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium text-gray-600 transition duration-150 ease-in-out cursor-pointer hover:text-gray-700 hover:bg-gray-50 focus:outline-none focus:text-gray-700 focus:bg-gray-50">
                        <i class="mr-2 fas fa-fw" :class="{ 'fa-eye-slash': !checked, 'fa-eye text-blue-600': checked }"></i>
                        <input @click="activate({ type: 'geojson', id: {{ $file->id }}, url: '{{ Storage::temporaryUrl($file->getPath(), Carbon::now()->addMinutes(60)) }}' })" id="{{ $file->id }}" type="checkbox" class="mr-2 text-blue-600 border-gray-300 rounded shadow-sm cursor-pointer focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"> {{ $file->name }}
                      </li>
                    @endforeach
                  @endif
                </ul>
              </div>
            </div>
          </div>

          <div class="flex flex-col items-center justify-center p-4" x-data="{ open: false }">
            <button @click="open = !open" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
              {{ __('Legend') }} <i class="ml-auto text-gray-400 fas fa-fw" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
            </button>

            <div class="transition-all duration-700" x-show="open">
              <ul class="list-none">
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  1. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(255, 255, 0);"></div> An Affected Cell or Connection
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  2. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(255, 255, 0);"></div> 2 to 4 Cells Affected
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  3. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(255, 255, 0);"></div> 5 or more Cells Affected
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  4. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(3, 175, 255);"></div> Bypass Diode
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  5. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(229, 0, 3);"></div> Disconnected / Deactivated
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  6. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(229, 0, 3);"></div> Connections or Others
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  7. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(255, 127, 0);"></div> Soiling / Dirty
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  8. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(255, 127, 0);"></div> Damaged Tracker
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm text-gray-700">
                  9. <div class="w-4 h-4 mx-2 rounded-full" style="background-color:rgb(255, 127, 0);"></div> Shadowing
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div id="map-container" class="w-full m-5 rounded h-96 md:h-screen md:w-4/5 md:m-0 md:rounded-none md:rounded-r-lg"></div>
      </div>

      <div x-data="{ overlay: false, panelInfo: false, anomalyInfo: true, imageInfo: false, annotations: false }" id="slide-over" :class="{ 'hidden': !overlay }" class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
        <div class="absolute inset-0 overflow-hidden">
          <!--
            Background overlay, show/hide based on slide-over state.

            Entering: "ease-in-out duration-500"
              From: "opacity-0"
              To: "opacity-100"
            Leaving: "ease-in-out duration-500"
              From: "opacity-100"
              To: "opacity-0"
          -->
          <div class="absolute inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
          <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <!--
              Slide-over panel, show/hide based on slide-over state.

              Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                From: "translate-x-full"
                To: "translate-x-0"
              Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                From: "translate-x-0"
                To: "translate-x-full"
            -->
            <div
              class="relative w-screen max-w-lg"
              x-transition:enter="transition ease duration-300"
              x-transition:enter-start="transform translate-x-0"
              x-transition:enter-end="transform translate-x-64"
              x-transition:leave="transition ease-in duration-300"
              x-transition:leave-start="transform opacity-100"
              x-transition:leave-end="transform opacity-0"
            >
              <!--
                Close button, show/hide based on slide-over state.

                Entering: "ease-in-out duration-500"
                  From: "opacity-0"
                  To: "opacity-100"
                Leaving: "ease-in-out duration-500"
                  From: "opacity-100"
                  To: "opacity-0"
              -->
              <div class="absolute top-0 left-0 flex pt-4 pr-4 mt-16 -ml-10 sm:-ml-12">
                <button @click="overlay = !overlay" type="button" class="p-1 text-white transition duration-150 ease-in-out bg-blue-900 bg-opacity-25 border-2 border-white border-opacity-25 rounded-md hover:bg-opacity-75 hover:border-opacity-50">
                  <i class="fas fa-times fa-fw"></i>
                </button>
              </div>

              <div class="flex flex-col h-full py-16 overflow-y-scroll bg-white shadow-xl">
                <div class="px-4 py-3 sm:px-6">
                  <h2 class="text-lg font-bold text-gray-900" id="slide-over-title">
                    <span id="panel" class="uppercase"></span>
                  </h2>
                </div>

                <livewire:sync-panel-information-form :model='$model'>

                <div class="relative flex-1 px-4 sm:px-6">
                  <div class="absolute inset-0 px-4 sm:px-6">
                    <div class="h-full" aria-hidden="true">
                      <table class="w-full table-auto" :class="{ 'mb-2': panelInfo }">
                        <button type="button" @click="anomalyInfo = !anomalyInfo" class="inline-flex items-center justify-between w-full px-4 py-2 my-2 font-semibold transition duration-150 ease-in-out border-transparent rounded-md focus:bg-gray-50 active:bg-gray-50 hover:bg-gray-50 focus:outline-none" :class="{ 'text-gray-600': !location, 'text-gray-700 bg-gray-50': location }">
                          {{ __('Thermal Anomaly') }} <i class="fas fa-fw" :class="{ 'fa-chevron-down': !anomalyInfo, 'fa-chevron-up': anomalyInfo }"></i>
                        </button>
                        <tbody x-show="anomalyInfo">
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Code') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="fail-code"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Type') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="fail-type"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Severity') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="severity-level"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Max Temperature') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="max-temperature"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Mean Temperature') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="mean-temperature"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Reference Temperature') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="ref-temperature"></td>
                          </tr>
                        </tbody>
                      </table>

                      <table class="w-full table-auto" :class="{ 'mb-2': panelInfo }">
                        <button type="button" @click="panelInfo = !panelInfo" class="inline-flex items-center justify-between w-full px-4 py-2 my-2 font-semibold transition duration-150 ease-in-out border-transparent rounded-md focus:bg-gray-50 active:bg-gray-50 hover:bg-gray-50 focus:outline-none" :class="{ 'text-gray-600': !location, 'text-gray-700 bg-gray-50': location }">
                          {{ __('Location') }} <i class="fas fa-fw" :class="{ 'fa-chevron-down': !panelInfo, 'fa-chevron-up': panelInfo }"></i>
                        </button>
                        <tbody x-show="panelInfo">
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Zone') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="zone"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Sub Zone') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="sub-zone"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('String') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="string"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Module') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="module"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('Serial Number') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="serial-number"></td>
                          </tr>
                        </tbody>
                      </table>

                      <div class="flex flex-col justify-start w-full">
                        <button type="button" @click="imageInfo = !imageInfo" class="inline-flex items-center justify-between w-full px-4 py-2 my-2 font-semibold transition duration-150 ease-in-out border-transparent rounded-md focus:bg-gray-50 active:bg-gray-50 hover:bg-gray-50 focus:outline-none" :class="{ 'text-gray-600': !location, 'text-gray-700 bg-gray-50': location }">
                          {{ __('Image File') }} <i class="fas fa-fw" :class="{ 'fa-chevron-down': !imageInfo, 'fa-chevron-up': imageInfo }"></i>
                        </button>
                        <div class="block w-full px-4 py-2" x-show="imageInfo">
                          <h2 id="img-filename" class="font-bold text-left text-gray-700">N/A</h2>
                          <p id="img-size" class="w-full mt-1 text-sm font-semibold text-gray-600 uppercase">N/A</p>
                          <img id="img-file" class="w-full mt-2 mb-4 rounded-lg shadow h-80" src="" alt="">
                        </div>
                      </div>

                      {{-- <div class="flex flex-col justify-start w-full">
                        <button type="button" @click="annotations = !annotations" class="inline-flex items-center justify-between w-full px-4 py-2 my-2 font-semibold transition duration-150 ease-in-out border-transparent rounded-md focus:bg-gray-50 active:bg-gray-50 hover:bg-gray-50 focus:outline-none" :class="{ 'text-gray-600': !location, 'text-gray-700 bg-gray-50': location }">
                          {{ __('Annotations') }} <i class="fas fa-fw" :class="{ 'fa-chevron-down': !annotations, 'fa-chevron-up': annotations }"></i>
                        </button>
                        <div class="block w-full px-4 py-2" x-show="annotations">
                          <livewire:annotations :model="$model">
                        </div>
                      </div> --}}
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  @else
    <div class="px-4 py-5 bg-white shadow sm:p-6 sm:rounded-lg">
      <h3 class="text-lg font-medium text-gray-900">{{ __('The files are NOT uploaded yet.') }}</h3>
      <div class="max-w-xl mt-3 text-sm text-gray-600">
        <p>{{ __('Go to the Files management tab and upload all the data related to this inspection.') }}</p>
      </div>
    </div>
  @endif

  <script>
    const layer = () => {
      return {
        checked: false,
        init() {

        },
        activate(payload = {}) {
          this.checked = ! this.checked;

          switch (payload.type) {
            case 'geotiff':
              Livewire.emit('handle-geotiff', payload);
              break;
            case 'geojson':
              Livewire.emit('handle-geojson', payload);
              break;
            default:
              break;
          }
        }
      };
    };

    document.addEventListener('livewire:load', () => {
      // Base layer group.
      const baseLayerGroup = new LayerGroup({
        layers: [
          new TileLayer({
            source: new XYZ({
              url: 'https://mt{0-3}.google.com/vt/lyrs=y&hl=en&x={x}&y={y}&z={z}',
            }),
            title: 'Hybrid',
            visible: true,
            maxZoom: 20,
          }),
          new TileLayer({
            source: new XYZ({
              url: 'https://mt{0-3}.google.com/vt/lyrs=p&hl=en&x={x}&y={y}&z={z}',
            }),
            title: 'Terrain',
            visible: false,
            maxZoom: 20,
          }),
          new TileLayer({
            source: new XYZ({
              url: 'https://mt{0-3}.google.com/vt/lyrs=s&hl=en&x={x}&y={y}&z={z}',
            }),
            title: 'Satelite',
            visible: false,
            maxZoom: 20,
          }),
        ],
      });

      // Map controls
      const fullScreenControl = new FullScreen();
      const overViewMapControl = new OverviewMap({
        collapsed: true,
        layers: [baseLayerGroup],
      });

      // Map creation.
      const map = new ol.Map({
        target: 'map-container',
        layers: [
          baseLayerGroup,
        ],
        view: new ol.View({
          center: fromLonLat([{{ $model->site->longitude }}, {{ $model->site->latitude }}], 'EPSG:4326'),
          zoom: 18,
          maxZoom: 20,
          projection: 'EPSG:4326',
        }),
        controls: defaults({ attribution: false }).extend([
          fullScreenControl,
          /* overViewMapControl, */
        ]),
      });

      // Sync map cache.
      syncMap(map);

      /**
      * Get the type of failure.
      *
      * @param {number} code - layer key.
      */
      const getFailType = (code = null) => {
        if (!code) {
          return 'N/A';
        }

        // Available fail types.
        const failTypes = {
          1: "{{ __('AN AFFECTED CELL OR CONNECTION') }}",
          2: "{{ __('2 TO 4 CELLS AFFECTED') }}",
          3: "{{ __('5 OR MORE CELLS AFFECTED') }}",
          4: "{{ __('BYPASS DIODE') }}",
          5: "{{ __('DISCONNECTED / DEACTIVATED SINGLE PANEL') }}",
          6: "{{ __('CONNECTIONS OR OTHERS') }}",
          7: "{{ __('SOILING / DIRTY') }}",
          8: "{{ __('DAMAGED TRACKER') }}",
          9: "{{ __('SHADOWING') }}",
          10: "{{ __('MISSING PANEL') }}",
          11: "{{ __('DISCONNECTED / DEACTIVATED STRING') }}",
          12: "{{ __('DISCONNECTED / DEACTIVATED ZONE') }}",
        };

        // subtract 1 to match the type, because the return value is an array.
        return Object.values(failTypes)[--code] ?? 'N/A';
      };

      /**
      * Get the severity level.
      *
      * @param {number} value - layer key.
      */
      const getSeverityLevel = (value = null) => {
        if (!value) {
          return 'N/A';
        }

        const severityLevels = {
          1: "{{ __('Low / Minor') }}",
          2: "{{ __('Middle / Major') }}",
          3: "{{ __('High / Critical') }}",
          4: 'N/A',
        };

        return severityLevels[value] ?? 'N/A';
      };

      /**
      * Retrieve the ir image file if it exists.
      *
      * @param {value} filename - filename.
      */
      const getImage = async (value = null) => {
        // placeholder image.
        const notFound = {
          file_name: 'N/A',
          file_url: `https://via.placeholder.com/512`,
          name: 'N/A',
          size: 'N/A',
        };

        if (value === 'undefined' || value === null) {
          return notFound;
        }

        return axios.post("{{ route('retrieve-image') }}", { filename: value, model_id: "{{ $model->id }}" })
          .then(response => {
            if (response.data.status === 'succeeded') {
              return {...response.data.data};
            }

            return notFound;
          })
          .catch(error => notFound);
      };

      // Slide over panel elements initial state.
      const slideOverElement = document.getElementById('slide-over');

      let featurePanel       = document.getElementById('panel');
      let featureSerial      = document.getElementById('serial-number');
      let featureZone        = document.getElementById('zone');
      let featureSubZone     = document.getElementById('sub-zone');
      let featureString      = document.getElementById('string');
      let featureModule      = document.getElementById('module');
      let featureFailCode    = document.getElementById('fail-code');
      let featureFailType    = document.getElementById('fail-type');
      let featureSeverity    = document.getElementById('severity-level');
      let featureTempMax     = document.getElementById('max-temperature');
      let featureTempMean    = document.getElementById('mean-temperature');
      let featureTempRef     = document.getElementById('ref-temperature');
      let featureImgFilename = document.getElementById('img-filename');
      let featureImgSize     = document.getElementById('img-size');
      let featureImgFile     = document.getElementById('img-file');

      const resetFeatures = () => {
        featurePanel.innerHTML       = 'N/A';
        featureSerial.innerHTML      = 'N/A';
        featureZone.innerHTML        = 'N/A';
        featureSubZone.innerHTML     = 'N/A';
        featureString.innerHTML      = 'N/A';
        featureModule.innerHTML      = 'N/A';
        featureFailCode.innerHTML    = 'N/A';
        featureFailType.innerHTML    = 'N/A';
        featureSeverity.innerHTML    = 'N/A';
        featureTempMax.innerHTML     = 'N/A';
        featureTempMean.innerHTML    = 'N/A';
        featureTempRef.innerHTML     = 'N/A';
        featureImgFilename.innerHTML = 'N/A';
        featureImgSize.innerHTML     = 'N/A';
        featureImgFile.innerHTML     = 'N/A';
      };

      // Vector slide over panel information.
      map.on('click', (evt) => {
        // Reset values.
        resetFeatures();

        map.forEachFeatureAtPixel(evt.pixel, async (feature, layer) => {
          const clickedFeaturePanel    = feature.get('panel') ?? 'N/A';
          const clickedFeatureSerial   = feature.get('serial') ?? 'N/A';
          const clickedFeatureZone     = feature.get('zone') ?? 'N/A';
          const clickedFeatureSubZone  = feature.get('subZone') ?? 'N/A';
          const clickedFeatureString   = feature.get('string') ?? 'N/A';
          const clickedFeatureModule   = feature.get('module') ?? clickedFeaturePanel;
          const clickedFeatureFailCode = feature.get('failCode') ?? 'N/A';
          const clickedFeatureFailType = feature.get('failCode') ?? 'N/A';
          const clickedFeatureSeverity = feature.get('severity') ?? 'N/A';
          const clickedFeatureTempMax  = feature.get('tempMax') ?? 'N/A';
          const clickedFeatureTempMean = feature.get('tempMean') ?? 'N/A';
          const clickedFeatureTempRef  = feature.get('tempRef') ?? 'N/A';
          const clickedFeatureFilename = feature.get('filename') ?? null;

          // Set values.
          featurePanel.innerHTML    = clickedFeaturePanel;
          featureSerial.innerHTML   = clickedFeatureSerial;
          featureZone.innerHTML     = clickedFeatureZone;
          featureSubZone.innerHTML  = clickedFeatureSubZone;
          featureString.innerHTML   = clickedFeatureString;
          featureModule.innerHTML   = clickedFeatureModule;
          featureFailCode.innerHTML = clickedFeatureFailCode;
          featureFailType.innerHTML = getFailType(clickedFeatureFailType);
          featureSeverity.innerHTML = getSeverityLevel(clickedFeatureSeverity);
          featureTempMax.innerHTML  = `${clickedFeatureTempMax} °C`;
          featureTempMean.innerHTML = `${clickedFeatureTempMean} °C`;
          featureTempRef.innerHTML  = `${clickedFeatureTempRef} °C`;

          await getImage(clickedFeatureFilename).then((img) => {
            featureImgFilename.innerHTML = clickedFeatureFilename;
            featureImgSize.innerHTML = img.size;
            featureImgFile.setAttribute('src', img.file_url);
            featureImgFile.setAttribute('alt', clickedFeatureFilename);
          });

          slideOverElement.classList.remove('hidden');

          // fulfill form data
          const panelSyncForm = document.getElementById('panel-sync-form');

          if (document.body.contains(panelSyncForm)) {
            const fillData = {
              panel_id: clickedFeaturePanel,
              panel_zone: clickedFeatureZone,
              panel_sub_zone: clickedFeatureSubZone,
              panel_string: clickedFeatureString,
            }

            const panelSyncFormElements = panelSyncForm.elements;

            const setFormValues = () => {
              panelSyncFormElements['panel_id'].value       = fillData.panel_id;
              panelSyncFormElements['panel_zone'].value     = fillData.panel_zone;
              panelSyncFormElements['panel_sub_zone'].value = fillData.panel_sub_zone;
              panelSyncFormElements['panel_string'].value   = fillData.panel_string;
            };

            setFormValues();

            Livewire.emit('panel-info', fillData);
          }
        });
      });

      // Styling of vector features.
      const stylesForVectorFeatures = (feature) => {
        // Properties.
        let failCodeProperty = feature.get('failCode');

        // Fail types colors - styles for polygons.
        const affectedCellOrConnectionFillStyle = new Fill({
          color: 'rgba(255, 255, 0, 0.3)',
        });

        const twoFourCellsAffectedFillStyle = new Fill({
          color: 'rgba(255, 255, 0, 0.3)',
        });

        const fiveOrMoreCellsAffectedFillStyle = new Fill({
          color: 'rgba(255, 255, 0, 0.3)',
        });

        const bypassDiodeFillStyle = new Fill({
          color: 'rgba(3, 175, 255, 0.3)',
        });

        const disconnectedDeactivatedFillStyle = new Fill({
          color: 'rgba(229, 0, 3, 0.3)',
        });

        const connectionsOrOthersFillStyle = new Fill({
          color: 'rgba(229, 0, 3, 0.3)',
        });

        const soilingDirtyFillStyle = new Fill({
          color: 'rgba(255, 127, 0, 0.3)',
        });

        const damagedTrackerFillStyle = new Fill({
          color: 'rgba(255, 127, 0, 0.3)',
        });

        const shadowingFillStyle = new Fill({
          color: 'rgba(255, 127, 0, 0.3)',
        });

        const missingPanelFillStyle = new Fill({
          color: 'rgba(12, 56, 112, 0.1)',
        });

        const defaultFillStyle = new Fill({
          color: 'rgba(0, 60, 136, 0.1)',
        });

        let featureTextLabel = new TextStyle({
          text: failCodeProperty.toString(),
          scale: 1.5,
          fill: new Fill({
            color: 'rgb(31 41 55)',
          }),
        });

        switch (failCodeProperty) {
          case 1:
            return feature.setStyle(new Style({
              fill: affectedCellOrConnectionFillStyle,
              stroke: new Stroke({
                color: [255, 255, 0, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 2:
            return feature.setStyle(new Style({
              fill: twoFourCellsAffectedFillStyle,
              stroke: new Stroke({
                color: [255, 255, 0, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 3:
            return feature.setStyle(new Style({
              fill: fiveOrMoreCellsAffectedFillStyle,
              stroke: new Stroke({
                color: [255, 255, 0, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 4:
            return feature.setStyle(new Style({
              fill: bypassDiodeFillStyle,
              stroke: new Stroke({
                color: [3, 175, 255, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 5:
            return feature.setStyle(new Style({
              fill: disconnectedDeactivatedFillStyle,
              stroke: new Stroke({
                color: [229, 0, 3, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 6:
            return feature.setStyle(new Style({
              fill: connectionsOrOthersFillStyle,
              stroke: new Stroke({
                color: [229, 0, 3, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 7:
            return feature.setStyle(new Style({
              fill: soilingDirtyFillStyle,
              stroke: new Stroke({
                color: [255, 127, 0, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 8:
            return feature.setStyle(new Style({
              fill: damagedTrackerFillStyle,
              stroke: new Stroke({
                color: [255, 127, 0, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 9:
            return feature.setStyle(new Style({
              fill: shadowingFillStyle,
              stroke: new Stroke({
                color: [255, 127, 0, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 10:
            return feature.setStyle(new Style({
              fill: missingPanelFillStyle,
              stroke: new Stroke({
                color: [12, 56, 112, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 11:
            return feature.setStyle(new Style({
              fill: disconnectedDeactivatedFillStyle,
              stroke: new Stroke({
                color: [229, 0, 3, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          case 12:
            return feature.setStyle(new Style({
              fill: disconnectedDeactivatedFillStyle,
              stroke: new Stroke({
                color: [229, 0, 3, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;

          default:
            return feature.setStyle(new Style({
              fill: defaultFillStyle,
              stroke: new Stroke({
                color: [0, 60, 136, 0.3],
                width: 1.25,
              }),
              text: featureTextLabel,
            }));
            break;
        }
      };

      // layers collection.
      let store = [];
      window.store = store;

      /**
      * Find the layer in the layers array with the given id.
      *
      * @param {number} id - layer key.
      */
      const getLayerById = (id = null) => store.find(layer => layer.id === id);

      // Events Listeners
      Livewire.on('handle-geojson', payload => {
        const checkbox = document.getElementById(payload.id);

        let data = {...payload};

        if (!getLayerById(data.id)) {
          data.layer = new VectorLayer({
            source: new Vector({
              format: new GeoJSON(),
              url: data.url,
            }),
            style: stylesForVectorFeatures,
            maxZoom: 20,
          });

          store.push(data);
          map.addLayer(data.layer);
          checkbox.setAttribute('checked');
        } else {
          checkbox.hasAttribute('checked')
            ? map.removeLayer(getLayerById(data.id).layer)
            : map.addLayer(getLayerById(data.id).layer);

          checkbox.toggleAttribute('checked');
        }
      });

      Livewire.on('handle-geotiff', async (payload) => {
        const checkbox = document.getElementById(payload.id);

        const spinner = document.getElementById(`spinner-${payload.id}`);
        spinner.classList.toggle('hidden');

        let data = {...payload};

        if (!getLayerById(data.id)) {
          // const pool = new Pool();
          const tiff = await fromUrl(data.url);
          const image = await tiff.getImage();
          const bbox = image.getBoundingBox();
          const width = image.getWidth();
          const height = image.getHeight();
          const rgb = await image.readRGB({ width, height });

          // Copy the rgb data from the geotiff to a canvas and then create a data url.
          const canvas = document.createElement('canvas');
          canvas.width = width;
          canvas.height = height;

          const ctx = canvas.getContext('2d');
          const imgData = ctx.getImageData(0, 0, width, height);
          const rgba = imgData.data;

          let j = 0;
          for (let i = 0; i < rgb.length; i += 3) {
            rgba[j] = rgb[i];
            rgba[j + 1] = rgb[i + 1];
            rgba[j + 2] = rgb[i + 2];
            rgba[j + 3] = 255;
            j += 4;
          }

          ctx.putImageData(imgData, 0, 0);

          data.layer = new ImageLayer({
            source: new ImageStatic({
              url: canvas.toDataURL(),
              projection: 'EPSG:4326',
              imageExtent: bbox,
            }),
            visible: true,
            maxZoom: 20,
          });

          store.push(data);
          map.addLayer(data.layer);
          spinner.classList.toggle('hidden');
          checkbox.setAttribute('checked');
        } else {
          checkbox.hasAttribute('checked')
            ? map.removeLayer(getLayerById(data.id).layer)
            : map.addLayer(getLayerById(data.id).layer);

          checkbox.toggleAttribute('checked');
        }
      });
    });
  </script>
</div>

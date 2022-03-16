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
            <button @click="open = !open" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md fotn-bold hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
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
            <button @click="open = !open" class="inline-flex items-center w-full px-3 py-2 text-sm font-medium font-bold leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
              {{ __('NDVI mean') }} <i class="ml-auto text-gray-400 fas fa-fw" :class="{ 'fa-chevron-down': !open, 'fa-chevron-up': open }"></i>
            </button>

            <div class="transition-all duration-700" x-show="open">
              <ul class="font-semibold text-gray-700 list-none">
                <li class="inline-flex items-center w-full px-3 py-2 text-sm">
                  <div class="w-4 h-4 mx-2 bg-red-500 rounded"></div> <span class="mx-2">mean</span> <i class="mx-2 fa-solid fa-greater-than-equal fa-fw"></i> 0.60
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm">
                  <div class="w-4 h-4 mx-2 bg-orange-400 rounded"></div> <span class="mx-2">0.60</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">mean</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">0.45</span>
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm">
                  <div class="w-4 h-4 mx-2 rounded bg-amber-300"></div> <span class="mx-2">0.45</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">mean</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">0.30</span>
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm">
                  <div class="w-4 h-4 mx-2 bg-green-500 rounded"></div> <span class="mx-2">0.30</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">mean</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">0.15</span>
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm">
                  <div class="w-4 h-4 mx-2 bg-teal-400 rounded"></div> <span class="mx-2">0.15</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">mean</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">0.00</span>
                </li>
                <li class="inline-flex items-center w-full px-3 py-2 text-sm">
                  <div class="w-4 h-4 mx-2 rounded bg-slate-900"></div> <span class="mx-2">mean</span> <i class="mx-2 fa-solid fa-greater-than fa-fw"></i> <span class="mx-2">0.00</span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div id="map-container" class="w-full m-5 rounded h-96 md:h-screen md:w-4/5 md:m-0 md:rounded-none md:rounded-r-lg"></div>
      </div>

      <div x-data="{ overlay: false, panelInfo: true }" id="slide-over" :class="{ 'hidden': !overlay }" class="fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true">
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
                  <h2 class="inline-flex items-center justify-start text-lg font-bold text-gray-900" id="slide-over-title">
                    <i class="mr-2 text-green-500 fa-solid fa-leaf fa-fw"></i> <span id="plant-number" class="uppercase"></span>
                  </h2>
                </div>

                <div class="relative flex-1 px-4 sm:px-6">
                  <div class="absolute inset-0 px-4 sm:px-6">
                    <div class="h-full" aria-hidden="true">
                      <table class="w-full table-auto" :class="{ 'mb-2': panelInfo }">
                        <button type="button" @click="panelInfo = !panelInfo" class="inline-flex items-center justify-between w-full px-4 py-2 my-2 font-semibold transition duration-150 ease-in-out border-transparent rounded-md focus:bg-gray-50 active:bg-gray-50 hover:bg-gray-50 focus:outline-none" :class="{ 'text-gray-600': !location, 'text-gray-700 bg-gray-50': location }">
                          {{ __('NDVI Information') }} <i class="fas fa-fw" :class="{ 'fa-chevron-down': !panelInfo, 'fa-chevron-up': panelInfo }"></i>
                        </button>
                        <tbody x-show="panelInfo">
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('NDVI Mean') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="ndvi"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('GNDVI Mean') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="gndvi"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('LCI Mean') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="lci"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('NDRE Mean') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="ndre"></td>
                          </tr>
                          <tr>
                            <th class="p-4 font-medium text-left text-gray-400 border-b">{{ __('OSAVI Mean') }}</th>
                            <td class="p-4 text-gray-500 border-b border-gray-100" id="osavi"></td>
                          </tr>
                        </tbody>
                      </table>
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

      // Slide over panel elements initial state.
      const slideOverElement = document.getElementById('slide-over');

      let featureNdviMean = document.getElementById('ndvi');
      let featureGndviMean = document.getElementById('gndvi');
      let featureLciMean = document.getElementById('lci');
      let featureNdreMean = document.getElementById('ndre');
      let featureOsaviMean = document.getElementById('osavi');
      let featurePlantNumber = document.getElementById('plant-number');

      const resetFeatures = () => {
        featureNdviMean.innerHTML = 'N/A';
        featureGndviMean.innerHTML = 'N/A';
        featureLciMean.innerHTML = 'N/A';
        featureNdreMean.innerHTML = 'N/A';
        featureOsaviMean.innerHTML = 'N/A';
        featurePlantNumber.innerHTML = 'N/A';
      };

      // Vector slide over panel information.
      map.on('click', (evt) => {
        // Reset values.
        resetFeatures();

        map.forEachFeatureAtPixel(evt.pixel, async (feature, layer) => {
          const clickedFeatureNdviMean = feature.get('NDVI_mean') ?? 'N/A';
          const clickedFeatureGndviMean = feature.get('GNDVI_mean') ?? 'N/A';
          const clickedFeatureLciMean = feature.get('LCI_mean') ?? 'N/A';
          const clickedFeatureNdreMean = feature.get('NDRE_mean') ?? 'N/A';
          const clickedFeatureOsaviMean = feature.get('OSAVI_mean') ?? 'N/A';
          const clickedFeaturePlantNumber = feature.get('plantNumber') ?? 'N/A';

          // Set values.
          featureNdviMean.innerHTML = clickedFeatureNdviMean.toFixed(2);
          featureGndviMean.innerHTML = clickedFeatureGndviMean.toFixed(2);
          featureLciMean.innerHTML = clickedFeatureLciMean.toFixed(2);
          featureNdreMean.innerHTML = clickedFeatureNdreMean.toFixed(2);
          featureOsaviMean.innerHTML = clickedFeatureOsaviMean.toFixed(2);
          featurePlantNumber.innerHTML = clickedFeaturePlantNumber;

          slideOverElement.classList.remove('hidden');
        });
      });

      // Styling of vector features.
      const stylesForVectorFeatures = (feature) => {
        // Properties.
        let ndviMeanProperty = feature.get('NDVI_mean');

        let ndviMean = ndviMeanProperty.toFixed(2);

        // styles for polygons.
        const bgSlate900FillStyle = new Fill({
          color: 'rgba(15, 23, 42, 0.3)',
        });

        const bgTeal400FillStyle = new Fill({
          color: 'rgba(45, 212, 191, 0.3)',
        });

        const bgGreen500FillStyle = new Fill({
          color: 'rgba(34, 197, 94, 0.3)',
        });

        const bgAmber300FillStyle = new Fill({
          color: 'rgba(252, 211, 77, 0.3)',
        });

        const bgOrange400FillStyle = new Fill({
          color: 'rgba(251, 146, 60, 0.3)',
        });

        const bgRed500FillStyle = new Fill({
          color: 'rgba(239, 68, 68, 0.3)',
        });

        const defaultFillStyle = new Fill({
          color: 'rgba(0, 60, 136, 0.1)',
        });

        if (ndviMean < 0) {
          feature.setStyle(new Style({
            fill: bgSlate900FillStyle,
            stroke: new Stroke({
              color: [15, 23, 42, 0.3],
              width: 1.25,
            })
          }));
        } else if (ndviMean >= 0 && ndviMean < 0.15) {
          feature.setStyle(new Style({
            fill: bgTeal400FillStyle,
            stroke: new Stroke({
              color: [45, 212, 191, 0.3],
              width: 1.25,
            })
          }));
        } else if (ndviMean >= 0.15 && ndviMean < 0.30) {
          feature.setStyle(new Style({
            fill: bgGreen500FillStyle,
            stroke: new Stroke({
              color: [34, 197, 94, 0.3],
              width: 1.25,
            })
          }));
        } else if (ndviMean >= 0.30 && ndviMean < 0.45) {
          feature.setStyle(new Style({
            fill: bgAmber300FillStyle,
            stroke: new Stroke({
              color: [252, 211, 77, 0.3],
              width: 1.25,
            })
          }));
        } else if (ndviMean >= 0.45 && ndviMean < 0.60) {
          feature.setStyle(new Style({
            fill: bgOrange400FillStyle,
            stroke: new Stroke({
              color: [251, 146, 60, 0.3],
              width: 1.25,
            })
          }));
        } else if (ndviMean >= 0.60) {
          feature.setStyle(new Style({
            fill: bgRed500FillStyle,
            stroke: new Stroke({
              color: [239, 68, 68, 0.3],
              width: 1.25,
            })
          }));
        } else {
          feature.setStyle(new Style({
            fill: defaultFillStyle,
            stroke: new Stroke({
              color: [0, 60, 136, 0.3],
              width: 1.25,
            })
          }));
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

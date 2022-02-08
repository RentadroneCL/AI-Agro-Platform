'use strict';

import 'georaster-layer-for-leaflet';
import georaster from 'georaster';

const L = window.L;
const GeoRasterLayer = window.GeoRasterLayer;

let map;
let layers = [];

// Google Maps Tile Layer
const GMaps = L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
  maxNativeZoom: 19,
  maxZoom: 25,
  subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
});

// OpenStreetMap Tile Layer
const OpenStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  maxNativeZoom: 19,
  maxZoom: 25,
  attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});

const baseMaps = {
  'Google Maps': GMaps,
  'OpenStreetMap': OpenStreetMap
};

let info = L.control({position: 'topright'});
let legend = L.control({position: 'bottomright'});

/**
 * Map constructor.
 *
 * @param {object} params - The map custom settings.
 */
function Map(params = {}) {
  this.params = params;
}

/**
 * Initialize a new map object.
 */
Map.prototype.initialize = function() {
  map = L.map(this.params.el, {
    // layers: [GMaps, OpenStreetMap],
    minZoom: this.params.minZoom,
    zoom: this.params.zoom
  }).setView([this.params.latitude, this.params.longitude]);

  // WIP - this will change to the layer control to switch between maps.

  // L.control.layers(baseMaps).addTo(map);

  /* L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxNativeZoom: 19,
      maxZoom: 25,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map); */

  L.tileLayer('https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
    maxNativeZoom: 19,
    maxZoom: 25,
    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
  }).addTo(map);

  // this.addLegendToMap();
  this.layerInfo();

  return this;
};

/**
 * Create a new raster layer if not present in the layers array.
 *
 * @param {object} payload - layer object.
 */
Map.prototype.createRasterLayer = async function(payload = undefined) {
  await fetch(payload.url)
    .then(response => response.arrayBuffer())
    .then(georaster)
    .then(georaster => {
      const rasterLayer = new GeoRasterLayer({
        georaster: georaster,
        opacity: 1.0,
        resolution: 256
      });

      payload.rasterLayer = rasterLayer;
      layers.push(payload);
      rasterLayer.addTo(map);
      // map.fitBounds(rasterLayer.getBounds());
    });
};

/**
 * Add raster layer to map.
 *
 * @param {object} payload - layer object.
 */
Map.prototype.addRasterLayer = async function(payload = undefined) {
  if (! this.getLayerById(payload.id)) {
    await this.createRasterLayer(payload);
    return;
  }

  const layer = this.getLayerById(payload.id);
  layer.rasterLayer.addTo(map);
  map.fitBounds(layer.rasterLayer.getBounds());
};

/**
 * Remove raster layer from the map.
 *
 * @param {object} payload - layer object.
 */
Map.prototype.removeRasterLayer = function(payload = undefined) {
  map.removeLayer(this.getLayerById(payload.id).rasterLayer);
};

/**
 * Find the layer in the layers array with the given id.
 *
 * @param {number} id - layer key.
 */
Map.prototype.getLayerById = function(id = null) {
  return layers.find(layer => layer.id === id);
};

/**
 * Create a new GeoJSON layer if not present in the layers array.
 *
 * @param {object} payload - layer object.
 */
Map.prototype.createGeojsonLayer = async function(payload = undefined) {
  await fetch(payload.url)
    .then(response => response.json())
    .then(geojson => {
      const geojsonLayer = L.geoJSON(geojson, {
        color: '#2C6BA2',
        weight: 1,
        opacity: 0.7,
        // Bind 'this' for the context application. if function returns void it's no need the bind.
        style: this.style.bind(this),
        onEachFeature: this.onEachFeature,
      });

      payload.geojsonLayer = geojsonLayer;
      layers.push(payload);
      geojsonLayer.addTo(map);
    });
};

/**
 * Types of failures detected in photovoltaic panels by UAV.
 *
 * @param {number} code - fail code.
 */
Map.prototype.getFailCodeColor = function(code = null) {
  switch (code) {
    case 1: // An affected cell or connection
      return '#FFFF00';

    case 2: // 2 to 4 cells affected
      return '#FFFF00';

    case 3: // 5 or more cells affected
      return '#FFFF00';

    case 4: // Bypass diode
      return '#03AFFF';

    case 5: // Disconnected / deactivated
      return '#E50003';

    case 6: // Connections or others
      return '#E50003';

    case 7: // Soiling / Dirty
      return '#FF7F00';

    case 8: // Damaged Tracker
      return '#FF7F00';

    case 9: // Shadowing
      return '#FF7F00';

    default: // Default color
      return '#2C6BA2';
  }
};

/**
 * A Function defining the Path options for styling GeoJSON lines and polygons,
 * called internally when data is added.
 *
 * @param {object} feature - Feature collection properties.
 */
Map.prototype.style = function(feature) {
  // does this feature have a property named failCode?
  if (feature.properties && feature.properties.failCode) {
    return {
      color: this.getFailCodeColor(feature.properties.failCode), // Stroke color
      fillColor: this.getFailCodeColor(feature.properties.failCode), // Fill color. Defaults to the value of the color option
      fillOpacity: 0.1, // Fill opacity.
      weight: 3, // Stroke width in pixels
      opacity: 0.7 // Stroke opacity
    };
  }

  return {
    fillColor: 'black',
    fillOpacity: 0,
    weight: 1,
    opacity: 0.7
  };
};

/**
 * A Function that will be called once for each created Feature,
 * after it has been created and styled.
 *
 * @param {object} feature
 * @param {object} layer
 */
Map.prototype.onEachFeature = function(feature, layer) {
  // Available fail types.
  const failTypes = {
    1: 'AN AFFECTED CELL OR CONNECTION',
    2: '2 TO 4 CELLS AFFECTED',
    3: '5 OR MORE CELLS AFFECTED',
    4: 'BYPASS DIODE',
    5: 'DISCONNECTED / DEACTIVATED',
    6: 'CONNECTIONS OR OTHERS',
    7: 'SOILING / DIRTY',
    8: 'DAMAGED TRACKER',
    9: 'SHADOWING',
  };

  // Get the type of failure.
  // subtract 1 to match the type, because the return value is an array.
  const getFailType = (code = null) => Object.values(failTypes)[--code];

  /* Get the severity level. */
  const getSeverityLevel = value => {
    const severityLevels = {
      1: 'Low / Minor',
      2: 'Middle / Major',
      3: 'High / Critical',
    };

    return severityLevels[value];
  };

  /**
   * Retrieve the ir image file if it exists.
   */
  const getImage = async (value) => {
    //placeholder image.
    let filename = `https://via.placeholder.com/160`;

    if (value === 'undefined') {
      return filename;
    }

    await axios.post(`/retrieve-image-file`, { filename: value })
      .then(response => {
        if (response.data.status === 'succeeded') {
          filename = String(response.data.data.file_url);
          return;
        }

        return;
      })
      .catch(error => {
        console.log(error.message);
      });

      return filename;
  };

  // Labeling Features
  if (feature.properties && feature.properties.panel !== null && feature.properties.failCode) {
    layer.bindTooltip(String(feature.properties.failCode), {
      permanent: true,
      direction: 'center',
      opacity: 0.7,
      className: 'custom-labels'
    }).openTooltip();
  }

  // Event highlight feature on the info pane.
  layer.on('mouseover', async function(e) {
    const props = e.target.feature.properties;

    if (props && props.panel !== null) {
      let img = await getImage(props.filename);

      info.infoDiv.innerHTML = `
        <div class="p-3 bg-white shadow rounded-md opacity-80">
          <h2 class="px-4 py-2 mb-3 font-bold tracking-wider text-gray-900 uppercase text-lg">Thermal Anomaly</h2>
          <h3 class="py-2 font-bold text-gray-700 uppercase mb-1">Location</h3>
          <table class="w-full text-left border border-collapse mb-4 text-gray-600">
            <tbody class="align-baseline">
              <tr class="text-left">
                <th class="px-4 py-3 text-sm font-semibold text-gray-700 border-b whitespace-nowrap bg-gray-50">Zone:</th>
                <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">${props.zone}</td>
              </tr>
              <tr class="text-left">
                <th class="px-4 py-3 text-sm font-semibold text-gray-700border-b whitespace-nowrap bg-gray-50">Sub Zone:</th>
                <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">${props.subZone ?? 'N/A'}</td>
              </tr>
              <tr class="text-left">
                <th class="px-4 py-3 text-sm font-semibold text-gray-700 border-b whitespace-nowrap bg-gray-50">String:</th>
                <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">${props.string}</td>
              </tr>
              <tr class="text-left">
                <th class="px-4 py-3 text-sm font-semibold text-gray-700 border-b whitespace-nowrap bg-gray-50">Module:</th>
                <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">${props.panel}</td>
              </tr>
            </tbody>
          </table>

          <h3 class="py-2 font-bold text-gray-700 uppercase mb-1">Failure Details</h3>
          <table class="w-full text-left border border-collapse text-gray-600">
            <tbody class="align-baseline">
              <tr class="text-left">
                <th class="px-4 py-3 text-sm font-semibold text-gray-700 border-b whitespace-nowrap bg-gray-50">Fail Code:</th>
                <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">${props.failCode}</td>
              </tr>
              <tr class="text-left">
                <th class="px-4 py-3 text-sm font-semibold text-gray-700 border-b whitespace-nowrap bg-gray-50">Fail Type:</th>
                <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">${getFailType(props.failCode)}</td>
              </tr>
              <tr class="text-left">
                <th class="px-4 py-3 text-sm font-semibold text-gray-700border-b whitespace-nowrap bg-gray-50">Severity:</th>
                <td class="px-4 py-3 text-sm text-gray-600 border-b whitespace-nowrap">${getSeverityLevel(props.severity) ?? 'N/A'}</td>
              </tr>
            </tbody>
          </table>

          <h3 class="py-2 font-bold text-gray-700 uppercase mb-1">Image</h3>
          <img class="w-full h-40 rounded-md border" src="${img}" alt="${props.filename ?? 'N/A'}">
        </div>
      `;
    }
  });

  layer.on('mouseout', function() {
    info.infoDiv.innerHTML = `
      <div class="p-3 bg-white shadow rounded-md opacity-80">
        <h4 class="font-semibold text-gray-700">Layer Information</h4>
        <p class="mt-1 text-gray-600">Hover over an active layer to see the information.</p>
      </div>
    `;
  });

  // does this feature have a property named string?
  /* if (feature.properties && feature.properties.string) {
    layer.bindPopup(feature.properties.string);
  } */

  // does this feature have a property named stringZone?
  /* if (feature.properties && feature.properties.stringZone) {
    layer.bindPopup(feature.properties.stringZone);
  } */

  // does this feature have a property named stringZone?
  /* if (feature.properties && feature.properties.failType) {
    layer.bindPopup(getFailType(props.failCode));
  } */
};

/**
 * Add GeoJSON layer to map.
 *
 * @param {object} payload - layer object.
 */
Map.prototype.addGeojsonLayer = async function(payload = undefined) {
  if (! this.getLayerById(payload.id)) {
    await this.createGeojsonLayer(payload);
    return;
  }

  this.getLayerById(payload.id).geojsonLayer.addTo(map);
};

/**
 * Remove GeoJSON layer from the map.
 *
 * @param {object} payload - layer object.
 */
Map.prototype.removeGeojsonLayer = function(payload = undefined) {
  map.removeLayer(this.getLayerById(payload.id).geojsonLayer);
};

/**
 * Fail types legend.
 */
Map.prototype.addLegendToMap = function () {
  const template = `
    <ul class="list-none flex flex-col text-xs text-gray-600 p-3 bg-white rounded-md shadow opacity-80">
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(254, 217, 118);"></div> 1. An Affected Cell or Connection
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(253, 141, 60);"></div> 2. 2 to 4 Cells Affected
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(227, 26, 28);"></div> 3. 5 or more Cells Affected
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(117, 146, 140);"></div> 4. Bypass Diode
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(172, 159, 202);"></div> 5. Disconnected / Deactivated
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(209, 213, 108);"></div> 6. Connections or Others
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(0, 180, 255);"></div> 7. Soiling / Dirty
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(219, 80, 41);"></div> 8. Damaged Tracker
      </li>
      <li class="inline-flex items-center px-3 py-2">
        <div class="rounded-full h-4 w-4 mr-2" style="background-color:rgb(10, 219, 167);"></div> 9. Shadowing
      </li>
    </ul>
  `;

  legend.onAdd = function() {
    this.legendDiv = L.DomUtil.create('div', 'legend');
    this.legendDiv.innerHTML = template;
    return this.legendDiv;
  };

  legend.addTo(map);
};

/**
 * Create information control.
 */
Map.prototype.layerInfo = function() {
  const template = `
    <div class="p-3 bg-white shadow rounded-md opacity-80">
      <h4 class="font-semibold text-gray-700">Layer Information</h4>
      <p class="mt-1 text-gray-600">Hover over an active layer.</p>
    </div>
  `;

  info.onAdd = function() {
    this.infoDiv = L.DomUtil.create('div', 'info');
    this.infoDiv.innerHTML = template;
    return this.infoDiv;
  };

  info.addTo(map);
};

export default Map;

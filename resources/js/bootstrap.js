import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true;

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
  window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
  console.error('CSRF token not found!');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

import GeoTIFF, { fromUrl } from 'geotiff';
window.GeoTIFF = GeoTIFF;
window.fromUrl= fromUrl;

import 'ol/ol.css';
import * as ol from 'ol';
window.ol = ol;

import { Group as LayerGroup, Tile as TileLayer, Vector as VectorLayer, Image as ImageLayer } from 'ol/layer';
import sync from 'ol-hashed';
import { XYZ, Vector, ImageStatic } from 'ol/source';
import { GeoJSON } from 'ol/format';
import { fromLonLat } from 'ol/proj';
import { FullScreen, OverviewMap, defaults } from 'ol/control';
import { MouseWheelZoom } from 'ol/interaction';
import { Style, Fill, Stroke, Text as TextStyle } from 'ol/style';

window.LayerGroup = LayerGroup;
window.TileLayer = TileLayer;
window.VectorLayer = VectorLayer;
window.ImageLayer = ImageLayer;
window.XYZ = XYZ;
window.syncMap = sync;
window.Vector = Vector;
window.GeoJSON = GeoJSON;
window.ImageStatic = ImageStatic;
window.fromLonLat = fromLonLat;
window.FullScreen = FullScreen;
window.OverviewMap = OverviewMap;
window.defaults = defaults;
window.MouseWheelZoom = MouseWheelZoom;
window.Style = Style;
window.Fill = Fill;
window.Stroke = Stroke;
window.TextStyle = TextStyle;

import '@uppy/core/dist/style.min.css';
import '@uppy/dashboard/dist/style.min.css';
import Uppy from '@uppy/core';
import Dashboard from '@uppy/dashboard';
import XHRUpload from '@uppy/xhr-upload';
window.Uppy = Uppy;
window.Dashboard = Dashboard;
window.XHRUpload = XHRUpload;

import '@fortawesome/fontawesome-free/css/all.min.css';
import '@fortawesome/fontawesome-free/js/all.min.js';

import Chart from 'chart.js/dist/Chart.min.js';
import 'chart.js/dist/Chart.min.css';
window.Chart = Chart;

import geojsonMerge from '@mapbox/geojson-merge';
window.geojsonMerge = geojsonMerge;

import { propEach } from '@turf/meta';
window.propEach = propEach;

import 'simple-datatables/dist/style.css';
import { DataTable } from 'simple-datatables';
window.DataTable = DataTable;

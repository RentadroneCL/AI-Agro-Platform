<div class="h-auto">
  <div class="grid grid-cols-1 mb-4 md:grid-cols-2 md:gap-6">
    <div class="flex flex-col justify-around w-auto p-6 bg-white md:p-8 md:col-span-2">
      <div class="inline-flex items-center justify-between mb-2">
        <div class="text-lg font-bold text-gray-900 md:text-xl">{{ $model->name }}</div>
        <div class="text-base font-medium text-gray-600 md:text-lg">{{ $model->commissioning_date->toDateString() }}</div>
      </div>
      <div class="max-w-2xl mt-3 mb-4 text-base text-gray-600">
        {{ __('The data presented in the following table count the number of panels affected in the plant, by type of failure, showing subtotals for each category.') }}
        {{-- {{ __('In total, ') }} <span id="detected-panels" class="font-semibold text-gray-900"></span> {{ __(' were inspected, of which:') }} --}}
      </div>
      <div class="inline-flex items-center justify-start w-auto py-4">
        <div class="w-auto h-full p-3 mr-4 bg-blue-200 border border-blue-200 rounded-md shadow">
          <i class="text-blue-500 fas fa-solar-panel fa-2x"></i>
        </div>
        <div class="flex flex-col justify-start">
          <h3 class="mb-2 text-lg font-bold text-gray-600 md:text-xl">{{ __('Detected Anomalies') }}</h3>
          <div id="anomalies" class="text-xl font-bold text-gray-900 md:text-2xl">
            <i class="text-gray-400 fas fa-circle-notch fa-fw fa-spin fa-lg" title="{{ __('Fetching data...') }}"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <x-jet-section-border></x-jet-section-border>

  <div class="hidden mb-4 sm:p-6 md:p-8">
    <canvas id="severity"></canvas>
    <div class="hidden py-8 sm:block">
      <div class="border-t border-gray-200"></div>
    </div>
  </div>

  <div class="hidden mb-4 sm:p-6 md:p-8">
    <canvas id=failTypes></canvas>
    <div class="hidden py-8 sm:block">
      <div class="border-t border-gray-200"></div>
    </div>
  </div>

  <div class="hidden mb-4 sm:p-6 md:p-8">
    <canvas id=failTypesBySeverity></canvas>
    <div class="hidden py-8 sm:block">
      <div class="border-t border-gray-200"></div>
    </div>
  </div>

  <div id="confirmed" class="hidden w-full p-6 md:p-8">
    <div class="mb-2 text-lg font-bold text-gray-900 md:text-xl">{{ __('Number of Confirmed Faults') }}</div>
    <div class="max-w-2xl mb-4 text-base text-gray-600">
      {{ __('The existence of panels that are under observation due to faults previously detected by the client was confirmed.') }}
    </div>

    <div class="inline-flex items-center justify-start w-auto py-4">
      <div class="w-auto h-full p-3 mr-4 bg-blue-200 border border-blue-200 rounded-md shadow">
        <i class="text-blue-500 fas fa-solar-panel fa-2x"></i>
      </div>
      <div class="flex flex-col justify-start">
        <h3 class="mb-2 text-lg font-bold text-gray-600 md:text-xl">{{ __('Confirmed Anomalies') }}</h3>
        <div id="confirmed-anomalies" class="text-xl font-bold text-gray-900 md:text-2xl">
          <i class="text-gray-400 fas fa-circle-notch fa-fw fa-spin fa-lg" title="{{ __('Fetching data...') }}"></i>
        </div>
      </div>
    </div>

    <div class="hidden mb-4">
      <canvas id=indeterminateFailTypesBySeverity></canvas>
      <div class="hidden py-8 sm:block">
        <div class="border-t border-gray-200"></div>
      </div>
    </div>
  </div>

  <div class="w-full h-auto overflow-x-auto overflow-y-auto">
    <div class="inline-block h-full min-w-full overflow-hidden text-center align-middle" id=dataset>
      <i class="text-gray-400 fas fa-circle-notch fa-fw fa-spin fa-3x"></i>
    </div>
  </div>

  <script>
    document.addEventListener('livewire:load', async () => {
      const files = [
        @foreach ($files as $file)
          "{!! $file->url !!}",
        @endforeach
      ];

      const payload = files.map(file => axios.get(file));

      await axios.all(payload)
        .then(axios.spread((...response) => {
          const features = response.map(item => item.data.features);
          let collection = [].concat(...features);
          const mergedGeoJSON = geojsonMerge.merge(collection);
          let dataset = [];

          propEach(mergedGeoJSON, function(properties) {
            if (properties.panel && properties.string && properties.zone) {
              dataset.push(properties);
            }

            return;
          });

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
              4: "{{ __('Indeterminate') }}",
            };

            return severityLevels[value] ?? 'N/A';
          };

          const filtered = [
            'filename', 'detectDate', 'layer', 'string', 'zone', 'subZone', 'panel', 'serial', 'failCode', 'failType', 'irradiance',
            'emissivity', 'tempAmb', 'rh', 'rasterMean', 'rasterMax', 'factor', 'severity', 'stringZone', 'stRastMean',
            'tempMean', 'tDiffNorm', 'tempReflx', 'tempMax', 'tempRef',
          ];

          dataset = dataset.map(item => _.pick(item, filtered));

          // Generate datasets table
          const attributesTableHeaders = {
            'filename': "{{ __('Filename') }}",
            'detectDate': "{{ __('Detected at') }}",
            'layer': "{{ __('Layer') }}",
            'string': "{{ __('String') }}",
            'zone': "{{ __('Zone') }}",
            'subZone': "{{ __('Sub Zone') }}",
            'panel': "{{ __('Panel') }}",
            'serial': "{{ __('Serial') }}",
            'failCode': "{{ __('Fail Code') }}",
            'failType': "{{ __('Fail Type') }}",
            'irradiance': "{{ __('Irradiance') }}",
            'emissivity': "{{ __('Emissivity') }}",
            'tempAmb': "{{ __('Ambience Temperature') }}",
            'rh': "{{ __('Relative Humidity') }}",
            'rasterMean': "{{ __('Raster Mean') }}",
            'rasterMax': "{{ __('Raster Max') }}",
            'factor': "{{ __('Factor') }}",
            'severity': "{{ __('Severity') }}",
            'stringZone': "{{ __('String Zone') }}",
            'stRastMean': "{{ __('String Raster Mean') }}",
            'tempMean': "{{ __('Temperature Mean') }}",
            'tDiffNorm': "{{ __('Temperature Differential Normalized') }}",
            'tempReflx': "{{ __('Temperature Reflected') }}",
            'tempMax': "{{ __('Temperature Max') }}",
            'tempRef': "{{ __('Reference Temperature') }}",
          };

          let table = document.createElement('table');
          let tbody = table.createTBody();
          let thead = table.createTHead();
          let theadRow = thead.insertRow();

          // const tableStyles = ['min-w-full', 'rounded', 'table-auto', 'border-separate', 'border', 'border-gray-50'];
          const tbodyStyles = ['bg-white'];
          // text-xs font-medium tracking-wider text-left text-gray-600 uppercase rounded bg-gray-50
          const theadStyles = ['text-xs', 'font-medium', 'tracking-wider', 'text-left', 'text-gray-600', 'uppercase', 'rounded', 'bg-gray-50',];

          // table.classList.add(...tableStyles);
          tbody.classList.add(...tbodyStyles);
          thead.classList.add(...theadStyles);

          Object.keys(dataset[0]).map(item => {
            const thStyles = ['px-4', 'py-2'];

            let th = document.createElement('th');
            th.classList.add(...thStyles);

            let text = document.createTextNode(attributesTableHeaders[item] ?? 'N/A');

            th.appendChild(text);
            theadRow.appendChild(th);
          });

          // Carry a deep copy to modify columns value without affecting the dataset.
          const rows = JSON.parse(JSON.stringify(dataset));

          for (let index = 0; index < rows.length; index++) {
            // Replace severity value
            let row = rows[index];
            row.severity = getSeverityLevel(row.severity);

            const trStyles = ['w-full', 'text-xs', 'text-gray-600', 'border-t', 'border-gray-100', 'hover:bg-gray-100'];

            let tr = document.createElement('tr');
            tr.classList.add(...trStyles);

            let td = Object.values(row).map(item => {
              const tdStyles = ['px-4', 'py-2'];

              let td = document.createElement('td');
              td.classList.add(...tdStyles);

              let text = document.createTextNode(item);
              td.appendChild(text);
              tr.appendChild(td);
            });

            tbody.appendChild(tr);
          }

          document.getElementById('dataset').innerText = '';
          document.getElementById('dataset').appendChild(table);

          const dataTable = new DataTable(table, {
            fixedHeight: true,
          });

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

          const failTypesBySeverityHeader = {
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

          /* Render fail types charts if the object has a failcode property */
          if (dataset.map(item => item.failCode).length > 0) {
            const failTypesCanvas = document.getElementById('failTypes');
            const failTypesChart = new Chart(failTypesCanvas.getContext('2d'), {
              type: 'doughnut',
              data: {
                labels: Object.values(failTypes),
                datasets: [
                  {
                    label: '# of Failures Detected',
                    data: [
                      _.filter(dataset, item => item.failCode === 1).length,
                      _.filter(dataset, item => item.failCode === 2).length,
                      _.filter(dataset, item => item.failCode === 3).length,
                      _.filter(dataset, item => item.failCode === 4).length,
                      _.filter(dataset, item => item.failCode === 5).length,
                      _.filter(dataset, item => item.failCode === 6).length,
                      _.filter(dataset, item => item.failCode === 7).length,
                      _.filter(dataset, item => item.failCode === 8).length,
                      _.filter(dataset, item => item.failCode === 9).length,
                      _.filter(dataset, item => item.failCode === 10).length,
                      _.filter(dataset, item => item.failCode === 11).length,
                      _.filter(dataset, item => item.failCode === 12).length,
                    ],
                    backgroundColor: [
                      'rgba(254, 217, 118, 0.2)', // An affected cell or connection
                      'rgba(253, 141, 60, 0.2)', // 2 to 4 cells affected
                      'rgba(227, 26, 28, 0.2)', // 5 or more cells affected
                      'rgba(117, 146, 140, 0.2)', // Bypass diode
                      'rgba(172, 159, 202, 0.2)', // Disconnected / deactivated
                      'rgba(209, 213, 108, 0.2)', // Connections or others
                      'rgba(0, 180, 255, 0.2)', // Soiling / Dirty
                      'rgba(219, 80, 41, 0.2)', // Damaged Tracker
                      'rgba(10, 219, 167, 0.2)', // Shadowing
                      'rgba(224, 87, 111, 0.2)', // Missing Panel
                      'rgba(27, 117, 129, 0.2)', // DISCONNECTED / DEACTIVATED STRING
                      'rgba(205, 80, 78, 0.2)', // DISCONNECTED / DEACTIVATED ZONE
                    ],
                    borderColor: [
                      'rgba(254, 217, 118, 1)',
                      'rgba(253, 141, 60, 1)',
                      'rgba(227, 26, 28, 1)',
                      'rgba(117, 146, 140, 1)',
                      'rgba(172, 159, 202, 1)',
                      'rgba(209, 213, 108, 1)',
                      'rgba(0, 180, 255, 1)',
                      'rgba(219, 80, 41, 1)',
                      'rgba(10, 219, 167, 1)',
                      'rgba(224, 87, 111, 1)',
                      'rgba(27, 117, 129, 1)',
                      'rgba(205, 80, 78, 1)',
                    ],
                    borderWidth: 1
                  },
                ]
              },
              options: {
                responsive: true,
                legend: {
                  position: 'top',
                },
                title: {
                  display: true,
                  text: 'Anomalies by Type'
                },
                animation: {
                  animateScale: true,
                  animateRotate: true
                }
              }
            });

            failTypesCanvas.parentNode.classList.toggle('hidden');
          }

          /* Render severity charts if the object has a severity property */
          if (_.filter(dataset, item => item.severity).length > 0) {
            // Total severity
            const lowSeverity    = _.filter(dataset, item => item.severity === 3).length;
            const mediumSeverity = _.filter(dataset, item => item.severity === 2).length;
            const highSeverity   = _.filter(dataset, item => item.severity === 1).length;
            const totalSeverity  = lowSeverity + mediumSeverity + highSeverity;

            document.getElementById('anomalies').innerText = totalSeverity ?? 0;

            const severityCanvas = document.getElementById('severity');
            const severityDoughnut = new Chart(severityCanvas.getContext('2d'), {
              type: 'doughnut',
              data: {
                datasets: [
                  {
                    data: [
                      _.filter(dataset, item => item.severity === 3).length,
                      _.filter(dataset, item => item.severity === 2).length,
                      _.filter(dataset, item => item.severity === 1).length,
                    ],
                    backgroundColor: [
                      'rgba(248, 113, 113, 0.2)', // High
                      'rgba(251, 191, 36, 0.2)', // Medium
                      'rgba(52, 211, 153, 0.2)', // Low
                    ],
                    borderColor: [
                      'rgba(248, 113, 113, 1)',
                      'rgba(251, 191, 36, 1)',
                      'rgba(52, 211, 153, 1)',
                    ],
                    label: 'Anomalies by severity'
                  }
                ],
                labels: [
                  'High',
                  'Medium',
                  'Low',
                ]
              },
              options: {
                responsive: true,
                legend: {
                  position: 'top',
                },
                title: {
                  display: true,
                  text: 'Anomalies by Severity'
                },
                animation: {
                  animateScale: true,
                  animateRotate: true
                }
              }
            });

            severityCanvas.parentNode.classList.toggle('hidden');

            const failTypesBySeverityCanvas = document.getElementById('failTypesBySeverity');
            const failTypesBySeverity = new Chart(failTypesBySeverityCanvas.getContext('2d'), {
              type: 'bar',
              data: {
                labels: Object.values(Object.entries(failTypesBySeverityHeader).slice(1, 9)),
                datasets: [
                  {
                    backgroundColor: 'rgba(248, 113, 113, 0.2)',
                    data: [
                      _.filter(dataset, item => item.failCode === 1 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 2 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 3 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 4 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 5 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 6 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 7 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 8 && item.severity === 3).length,
                      _.filter(dataset, item => item.failCode === 9 && item.severity === 3).length,
                    ],
                    label: 'High Severity',
                    borderWidth: 1
                  },
                  {
                    backgroundColor: 'rgba(251, 191, 36, 0.2)',
                    data: [
                      _.filter(dataset, item => item.failCode === 1 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 2 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 3 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 4 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 5 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 6 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 7 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 8 && item.severity === 2).length,
                      _.filter(dataset, item => item.failCode === 9 && item.severity === 2).length,
                    ],
                    label: 'Medium Severity',
                    borderWidth: 1
                  },
                  {
                    backgroundColor: 'rgba(52, 211, 153, 0.2)',
                    data: [
                      _.filter(dataset, item => item.failCode === 1 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 2 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 3 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 4 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 5 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 6 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 7 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 8 && item.severity === 1).length,
                      _.filter(dataset, item => item.failCode === 9 && item.severity === 1).length,
                    ],
                    label: 'Low Severity',
                    borderWidth: 1
                  },
                ]
              },
              options: {
                title: {
                display: true,
                text: '# of Failures by Severity'
              },
              tooltips: {
                mode: 'index',
                intersect: false
              },
              responsive: true,
              scales: {
                xAxes: [{
                  beginAtZero: true,
                  stacked: true,
                }],
                yAxes: [{
                  beginAtZero: true,
                  stacked: true
                }]
              }
            }
          });

          failTypesBySeverityCanvas.parentNode.classList.toggle('hidden');
        }

        // Confirmed anomalies.
        const indeterminateSeverity = _.filter(dataset, item => item.severity === 4);

        if (indeterminateSeverity.length > 0) {
          document.getElementById('confirmed').classList.toggle('hidden');
          document.getElementById('confirmed-anomalies').innerText = indeterminateSeverity.length;

          const filteredIndeterminateDataset = indeterminateSeverity.map(item => _.pick(item, ['subZone', 'failCode', 'severity']));

          const indeterminateFailTypesBySeverityCanvas = document.getElementById('indeterminateFailTypesBySeverity');
          const indeterminateFailTypesBySeverity = new Chart(indeterminateFailTypesBySeverityCanvas.getContext('2d'), {
              type: 'bar',
              data: {
                labels: Object.values(failTypesBySeverityHeader),
                datasets: [
                  {
                    backgroundColor: 'rgba(248, 113, 113, 0.2)',
                    data: [
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 1 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 2 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 3 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 4 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 5 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 6 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 7 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 8 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 9 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 10 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 11 && item.severity === 4).length,
                      _.filter(filteredIndeterminateDataset, item => item.failCode === 12 && item.severity === 4).length,
                    ],
                    label: "{{ __('Indeterminate') }}",
                    borderWidth: 1
                  },
                ]
              },
              options: {
                title: {
                display: true,
                text: "{{ __('Confirmed Failures by Severity') }}"
              },
              tooltips: {
                mode: 'index',
                intersect: false
              },
              responsive: true,
              scales: {
                xAxes: [{
                  beginAtZero: true,
                  stacked: true,
                }],
                yAxes: [{
                  beginAtZero: true,
                  stacked: true
                }]
              }
            }
          });

          indeterminateFailTypesBySeverityCanvas.parentNode.classList.toggle('hidden');
        }
      }))
      .catch(errors => {
        // react on errors.
        console.error(errors);
      });
    });
  </script>
</div>

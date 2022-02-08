<div x-data="{ open: false, collection: 'Default' }" >
    <div class="inline-flex items-center justify-between mb-2">
        <div class="mr-4">
            <div class="relative" @click.away="open = false" @close.stop="open = false">
                <div @click="open = ! open">
                    <span class="inline-flex rounded-md">
                        <button type="button" class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50">
                            <span x-ref="uploadType">{{ __('Default') }}</span>

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </span>
                </div>

                <div x-show="open"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute left-0 z-50 w-48 py-1 mt-2 origin-top-left bg-white rounded-md shadow-lg"
                        style="display: none;"
                        @click="open = false">
                    <div class="left-0 py-1 origin-top-left bg-white rounded-md ring-1 ring-black ring-opacity-5">
                        <!-- Collection Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Manage Collections') }}
                        </div>

                        <x-jet-dropdown-link @click.prevent="
                            collection = 'Orthomosaic/GeoJSON'
                            $refs.uploadType.innerText = collection
                        ">
                            {{ __('Orthomosaic/GeoJSON') }}
                        </x-jet-dropdown-link>

                        <x-jet-dropdown-link @click.prevent="
                            collection = 'IR'
                            $refs.uploadType.innerText = collection
                        ">
                            {{ __('IR') }}
                        </x-jet-dropdown-link>

                        <x-jet-dropdown-link @click.prevent="
                            collection = 'RGB'
                            $refs.uploadType.innerText = collection
                        ">
                            {{ __('RGB') }}
                        </x-jet-dropdown-link>

                        <x-jet-dropdown-link  @click.prevent="
                            collection = 'PDF'
                            $refs.uploadType.innerText = collection
                        ">
                            {{ __('PDF') }}
                        </x-jet-dropdown-link>
                    </div>
                </div>
            </div>
        </div>

        <x-jet-secondary-button id="default" x-show="collection === 'Default'" x-cloak>
            {{ __('Upload Files') }}
        </x-jet-secondary-button>

        <x-jet-secondary-button id="orthomosaic" x-show="collection === 'Orthomosaic/GeoJSON'" x-cloak>
            {{ __('Upload Orthomosaic/GeoJSON') }}
        </x-jet-secondary-button>

        <x-jet-secondary-button id="ir" x-show="collection === 'IR'" x-cloak>
            {{ __('Upload IR') }}
        </x-jet-secondary-button>

        <x-jet-secondary-button id="rgb" x-show="collection === 'RGB'" x-cloak>
            {{ __('Upload RGB') }}
        </x-jet-secondary-button>

        <x-jet-secondary-button id="pdf" x-show="collection === 'PDF'" x-cloak>
            {{ __('Upload PDF') }}
        </x-jet-secondary-button>
    </div>

    <div id=dashboard></div>

    <script>
        document.addEventListener('livewire:load', function() {
            /* default uploader */
            const defaultUploader = new Uppy({
                autoProceed: false,
                allowMultipleUploads: true,
                restrictions: {
                    maxFileSize: 943718400,
                    allowedFileTypes: [
                        'image/*',
                        'application/pdf',
                        'application/octet-stream',
                        'application/vnd.ms-excel',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ]
                }
            })
            .use(Dashboard, {
                target: '#dashboard',
                trigger: '#default',
                proudlyDisplayPoweredByUppy: false
            })
            .use(XHRUpload, {
                fieldName: 'files[]',
                endpoint: '{{ route('files-upload', [$inspection, 'default']) }}',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
                },
                bundle: true,
                timeout: 900 * 1000 // 15 min.
            })
            .on('upload-success', (file, response) => {
                console.log(file.name, response.uploadURL);
            })
            .on('complete', (result) => {
                Livewire.emit('complete-files-upload', {
                    'inspection_id': @this.id,
                    'files': result.successful,
                    'collection_name': 'default'
                });
            })
            .on('upload-error', (file, error, response) => {
                console.log(response);
                console.log('error with file:', file.id);
                console.log('error message:', error);
            })
            .on('error', (error) => {
                console.error(error.stack);
            });

            /* Orthomosaic/Shape uploader */
            const orthoUploader = new Uppy({
                autoProceed: false,
                allowMultipleUploads: true,
                restrictions: {
                    maxFileSize: 943718400,
                    allowedFileTypes: [
                        'image/tiff',
                        'application/geo+json',
                        'application/octet-stream'
                    ]
                }
            })
            .use(Dashboard, {
                target: '#dashboard',
                trigger: '#orthomosaic',
                proudlyDisplayPoweredByUppy: false
            })
            .use(XHRUpload, {
                fieldName: 'files[]',
                endpoint: '{{ route('files-upload', [$inspection, 'orthomosaic-geojson']) }}',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
                },
                bundle: true,
                timeout: 900 * 1000 // 15 min.
            })
            .on('complete', (result) => {
                Livewire.emit('complete-files-upload', {
                    'inspection_id': @this.id,
                    'files': result.successful,
                    'collection_name': 'orthomosaic-geojson'
                });
            });

             /* IR uploader */
            const irUploader = new Uppy({
                autoProceed: false,
                allowMultipleUploads: true,
                restrictions: {
                    maxFileSize: 943718400,
                    allowedFileTypes: [
                        '.jpg',
                        '.jpeg',
                    ]
                }
            })
            .use(Dashboard, {
                target: '#dashboard',
                trigger: '#ir',
                proudlyDisplayPoweredByUppy: false
            })
            .use(XHRUpload, {
                fieldName: 'files[]',
                endpoint: '{{ route('files-upload', [$inspection, 'ir']) }}',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
                },
                bundle: true,
                timeout: 900 * 1000 // 15 min.
            })
            .on('complete', (result) => {
                Livewire.emit('complete-files-upload', {
                    'inspection_id': @this.id,
                    'files': result.successful,
                    'collection_name': 'ir'
                });
            });

             /* RGB uploader */
            const rgbUploader = new Uppy({
                autoProceed: false,
                allowMultipleUploads: true,
                restrictions: {
                    maxFileSize: 943718400,
                    allowedFileTypes: [
                        '.jpg',
                        '.jpeg',
                    ]
                }
            })
            .use(Dashboard, {
                target: '#dashboard',
                trigger: '#rgb',
                proudlyDisplayPoweredByUppy: false
            })
            .use(XHRUpload, {
                fieldName: 'files[]',
                endpoint: '{{ route('files-upload', [$inspection, 'rgb']) }}',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
                },
                bundle: true,
                timeout: 900 * 1000 // 15 min.
            })
            .on('complete', (result) => {
                Livewire.emit('complete-files-upload', {
                    'inspection_id': @this.id,
                    'files': result.successful,
                    'collection_name': 'rgb'
                });
            });

            /* PDF uploader */
            const pdfUploader = new Uppy({
                autoProceed: false,
                allowMultipleUploads: true,
                restrictions: {
                    maxFileSize: 943718400,
                    allowedFileTypes: [
                        'application/pdf',
                    ]
                }
            })
            .use(Dashboard, {
                target: '#dashboard',
                trigger: '#pdf',
                proudlyDisplayPoweredByUppy: false
            })
            .use(XHRUpload, {
                fieldName: 'files[]',
                endpoint: '{{ route('files-upload', [$inspection, 'pdf']) }}',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
                },
                bundle: true,
                timeout: 900 * 1000 // 15 min.
            })
            .on('complete', (result) => {
                Livewire.emit('complete-files-upload', {
                    'inspection_id': @this.id,
                    'files': result.successful,
                    'collection_name': 'pdf'
                });
            });
        });
    </script>
</div>

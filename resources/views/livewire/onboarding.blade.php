<div x-data="stepper()" x-init="init()">
    <x-jet-action-section x-show="step !== 3" @transaction-error="step = 1">
        <x-slot name="title">{{ __('Before you start') }}</x-slot>

        <x-slot name="description">
            {{ __('Before you start, collect the information you need to complete the order:') }}

            <ul class="px-4 mt-1 text-sm text-gray-600 list-disc">
                <li class="">
                    <span class="font-semibold text-gray-700">{{ __('Site information:') }}</span> {{ __('collect this information if you are requesting the first inspection of a new site.') }}
                </li>
                <li class="">
                    {{ __('Next, upload the as-built for the site.') }}
                </li>
            </ul>

            <p class="mt-2 text-sm text-gray-600">
                {{ __('You’ll receive a confirmation email, once you’ve submitted your order.') }}
            </p>
        </x-slot>

        <x-slot name="content">

            <div id="step-1" x-show="step === 1">
                <x-jet-action-message on="saved">
                    <div class="p-3 mb-3 text-blue-700 bg-blue-100 border-2 border-blue-200 rounded-md shadow">
                        {{ __('Saved.') }}
                    </div>
                </x-jet-action-message>

                <x-jet-action-message on="transaction-error">
                    <div class="p-3 mb-3 text-red-700 bg-red-100 border-2 border-red-200 rounded-md shadow">
                        {{ __('An unexpected error occurred.') }}
                    </div>
                </x-jet-action-message>

                <h3 class="mb-3 text-lg font-medium text-gray-900">{{ __('Before you start, collect the information you need to complete the order:') }}</h3>

                <div class="grid grid-cols-6 gap-6">
                    <x-jet-input id="user_id" type="hidden" class="block w-full mt-1" wire:model="state.user_id" />

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="name" value="{{ __('Name, as it will appear on the report') }}" />
                        <x-jet-input id="name" type="text" class="block w-full mt-1" wire:model.lazy="state.name" autocomplete="name" />
                        <x-jet-input-error for="state.name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="position" value="{{ __('Position') }}" />
                        <x-jet-input id="position" type="text" class="block w-full mt-1" wire:model.lazy="state.position" autocomplete="position" />
                        <x-jet-input-error for="state.position" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="address" value="{{ __('Site address, as it will appear on the report') }}" />
                        <x-jet-input id="address" type="text" class="block w-full mt-1" wire:model.lazy="state.address" autocomplete="address" />
                        <x-jet-input-error for="state.address" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="installed_capacity" value="{{ __('MWp of installed capacity, to the nearest known decimal place.') }}" />
                        <x-jet-input id="installed_capacity" type="text" class="block w-full mt-1" wire:model.lazy="state.installed_capacity" />
                        <x-jet-input-error for="state.installed_capacity" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-jet-label for="message" value="{{ __('Message') }}" />
                        <textarea id="message" rows="3" placeholder="{{ __('Brief description of how can help you.') }}" class="w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" wire:model.lazy="state.message"></textarea>
                        <x-jet-input-error for="state.message" class="mt-2" />
                    </div>
                </div>

                <div class="inline-flex items-center justify-end w-full mt-5">
                    <x-jet-button x-on:click="next()" wire:click="store">{{ __('Save and continue') }}</x-jet-button>
                </div>
            </div>

            <div id="step-2" x-show="step === 2">
                <x-jet-action-message on="saved">
                    <div class="p-3 mb-3 text-blue-700 bg-blue-100 border-2 border-blue-200 rounded-md shadow">
                        {{ __('Site information has been saved.') }}
                    </div>
                </x-jet-action-message>

                <x-jet-action-message on="transaction-error" @transaction-error="prev()">
                    <div class="p-3 mb-3 text-red-700 bg-red-100 border-2 border-red-200 rounded-md shadow">
                        {{ __('An unexpected error occurred.') }}
                    </div>
                </x-jet-action-message>

                <h3 class="text-lg font-medium text-gray-900">{{ __('Providing As-Built Information for your Site') }}</h3>

                <div class="max-w-xl mt-3 text-sm text-gray-600">
                    {{ __('To enable the delivery of this feature, we need the as-built for the inspected site. The as-built you provide should include the string layout for the site.') }}

                    {{ __('As part of the ordering process, we request that you provide the KML design of the solar farm. This will allow for the most accurate digital representation of your solar farm and increase efficiency in the data collection process.') }}
                </div>

                <div class="max-w-xl mt-3 text-xs text-gray-600">
                    <p>{{ __('Limit each upload session to a maximum of 200 files.') }}</p>
                    <p>{{ __('The maximum file size session allowed is 900MB.') }}</p>
                    <p>{{ __('File Support: jpg, jpeg, tif, kml, kmz, shp, dwg, pdf.') }}</p>
                </div>

                <div wire:ignore id="upload-files" class="mt-3"></div>

                <div class="inline-flex items-center justify-end w-full mt-5">
                    <x-jet-secondary-button x-on:click="prev()" class="mr-2">{{ __('Back') }}</x-jet-secondary-button>
                    <x-jet-button x-on:click="next()" wire:click="finish">{{ __('Finish') }}</x-jet-button>
                </div>
            </div>
        </x-slot>
    </x-jet-action-section>

    <div id="step-3" x-show="step === 3">
        <h3 class="mb-4 text-lg font-medium text-gray-900">{{ __('You’ll receive a confirmation email, once you’ve submitted your order.') }}</h3>
        <livewire:contact-form />
    </div>

    <script>
        const stepper = () => {
            return {
                step: 1,
                init() {
                  this.uploader();
                },
                next() {
                    ++this.step;
                },
                prev() {
                    --this.step;
                },
                uploader() {
                    new Uppy({
                        autoProceed: true,
                        allowMultipleUploads: true,
                        restrictions: {
                            maxFileSize: 943718400,
                            allowedFileTypes: [
                                'image/*',
                                'application/pdf',
                                'application/geo+json',
                                'application/octet-stream',
                                'application/vnd.google-earth.kml+xml',
                                'application/vnd.google-earth.kmz',
                                'application/acad',
                                'image/vnd.dwg',
                                'image/x-dwg',
                            ]
                        }
                    })
                    .use(Dashboard, {
                        target: document.getElementById('upload-files'),
                        inline: true,
                        hideUploadButton: true,
                        doneButtonHandler: null,
                        proudlyDisplayPoweredByUppy: false
                    })
                    .use(XHRUpload, {
                        fieldName: 'files[]',
                        endpoint: '{{ route('upload-onboarding-files') }}',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").content
                        },
                        bundle: true,
                        timeout: 900 * 1000 // 15 min.
                    })
                    .on('complete', (result) => console.log(result));
                }
            };
        };
    </script>
</div>

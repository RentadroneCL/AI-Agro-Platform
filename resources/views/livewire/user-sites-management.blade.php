<div x-data="table()" x-init="init()">
  <x-jet-action-section>
    <x-slot name="title">
      {{ __('Site Management') }}
    </x-slot>

    <x-slot name="description">
      {{ __('Register new sites or find the site and click on it to continue to the inspection page.') }}
    </x-slot>

    <x-slot name="content">
      <div class="mb-5">
        <livewire:new-site-dialog-modal-form :user="$user">
      </div>

      <div class="w-full overflow-x-auto">
        <div class="inline-block min-w-full overflow-hidden align-middle">
          <table id="sites-table" class="min-w-full divide-y divide-gray-200 rounded">
            <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase rounded bg-gray-50">
              <tr>
                <th class="px-6 py-3">{{ __('Name') }}</th>
                <th class="px-6 py-3">{{ __('Commissioning date') }}</th>
                <th class="relative px-6 py-3 rounded-tr">
                  <span class="sr-only">{{ __('Manage') }}</span>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              @foreach ($sites as $site)
                <tr id="{{ $site->id }}">
                  <td class="px-6 py-4 whitespace-nowrap">{{ $site->name }}</td>
                  <td class="px-6 py-4 whitespace-nowrap">
                    {{ $site->commissioning_date->toDateString() }}
                  </td>
                  <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                    <a class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50" href="{{ route('site.show', $site) }}" title="{{ __('Manage') }}">
                      <i class="text-gray-400 fas fa-cog fa-fw"></i>
                    </a>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </x-slot>
  </x-jet-action-section>

  <script>
    const table = () => {
      return {
        init() {
          this.render();
        },
        render() {
          return new DataTable(document.getElementById('sites-table'), {
            fixedHeight: true,
          });
        }
      };
    };
  </script>
</div>

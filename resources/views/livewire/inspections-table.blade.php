@if ($inspections->count())
  <div class="w-full overflow-x-auto">
    <div class="inline-block min-w-full overflow-hidden align-middle">
      <table x-data="table()" x-init="init()" id="inspections-table">
        <thead class="text-xs font-medium tracking-wider text-left text-gray-600 uppercase rounded bg-gray-50">
          <tr class="border-b">
            <th class="px-6 py-3">{{ __('ID') }}</th>
            <th class="px-6 py-3">{{ __('Name') }}</th>
            <th class="px-6 py-3">{{ __('Commissioning Date') }}</th>
            <th class="relative px-6 py-3 rounded-tr">
              <span class="sr-only">{{ __('Manage') }}</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white">
          @foreach ($inspections as $inspection)
            <tr id="{{ $inspection->id }}">
              <td class="px-6 py-4 whitespace-nowrap">{{ $inspection->id }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ $inspection->name }}</td>
              <td class="px-6 py-4 whitespace-nowrap">{{ __($inspection->commissioning_date->toFormattedDateString()) }}</td>
              <td class="px-6 py-4 whitespace-nowrap">
                <a class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50" href="{{ route('inspection.show', $inspection) }}" title="{{ __('Manage') }}">
                  <i class="text-gray-400 fas fa-cog fa-fw"></i>
                </a>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
@else
  <div class="max-w-xl text-sm text-gray-600">
    <div class="text-lg font-medium text-gray-900l">{{ __('There are no inspections for this site.') }}</div>
    <div class="text-sm text-gray-600 t-3">{{ __('Go ahead and create a new one!') }}</div>
  </div>
@endif

<script>
  const table = () => {
    return {
      init() {
        this.render();
      },
      render() {
        return new DataTable(document.getElementById('inspections-table'), {
          fixedHeight: true,
        });
      }
    };
  };
</script>

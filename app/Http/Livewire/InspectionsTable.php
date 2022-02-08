<?php

namespace App\Http\Livewire;

use App\Models\Site;
use Livewire\Component;
use Illuminate\View\View;
use Livewire\WithPagination;

class InspectionsTable extends Component
{
    use WithPagination;

    /**
     * Site model.
     *
     * @var \App\Models\Site $site
     */
    public Site $site;

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.inspections-table', [
            'inspections' => $this->site->inspections()->paginate(),
        ]);
    }
}

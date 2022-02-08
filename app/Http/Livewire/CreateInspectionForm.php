<?php

namespace App\Http\Livewire;

use App\Models\Inspection;
use App\Models\Site;
use Livewire\Component;

class CreateInspectionForm extends Component
{
    public Site $site;

    /**
     * The component's state.
     *
     * @var array
     */
    public array $state = [
        'site_id' => '',
        'name' => '',
        'commissioning_date' => '',
    ];

    public function mount()
    {
        $this->state['site_id'] = $this->site->id;
    }

    public function store()
    {
        $this->resetErrorBag();

        $newInspection = Inspection::create($this->state);

        return redirect()->route('inspection.show', $newInspection->refresh());
    }

    public function render()
    {
        return view('livewire.create-inspection-form');
    }
}

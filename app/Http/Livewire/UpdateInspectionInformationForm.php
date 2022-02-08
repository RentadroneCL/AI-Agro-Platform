<?php

namespace App\Http\Livewire;

use App\Models\Inspection;
use Illuminate\View\View;
use Livewire\Component;

class UpdateInspectionInformationForm extends Component
{
    /**
     * Inspection model.
     *
     * @var \App\Models\Inspection $inspection
     */
    public Inspection $inspection;

    /**
     * The component's state.
     *
     * @var array
     */
    public array $state = [
        'name' => '',
        'commissioning_date' => ''
    ];

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['name'] = $this->inspection->name;
        $this->state['commissioning_date'] = $this->inspection->commissioning_date->toDateString();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function update()
    {
        $this->resetErrorBag();

        $this->inspection->update($this->state);

        $this->emit('saved');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.update-inspection-information-form');
    }
}

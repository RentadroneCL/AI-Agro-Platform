<?php

namespace App\Http\Livewire;

use App\Models\Site;
use Illuminate\View\View;
use Livewire\Component;

class UpdateSiteInformationForm extends Component
{
    /**
     * Site model.
     *
     * @var \App\Models\Site $site
     */
    public Site $site;

    /**
     * The component's state.
     *
     * @var array
     */
    public array $state = [
        'user_id' => '',
        'name' => '',
        'address' => '',
        'latitude' => '',
        'longitude' => '',
        'commissioning_date' => ''
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.user_id' => 'required|integer',
        'state.name' => 'required|string|min:6',
        'state.address' => 'required|string|min:6',
        'state.latitude' => 'required|numeric',
        'state.longitude' => 'required|numeric',
        'state.commissioning_date' => 'required|date',
    ];

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['user_id'] = $this->site->user_id;
        $this->state['name'] = $this->site->name;
        $this->state['address'] = $this->site->address;
        $this->state['latitude'] = $this->site->latitude;
        $this->state['longitude'] = $this->site->longitude;
        $this->state['commissioning_date'] = $this->site->commissioning_date->toDateString();
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function update(): void
    {
        $this->resetErrorBag();

        $this->validate();

        $this->site->update($this->state);

        $this->emit('saved');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.update-site-information-form');
    }
}

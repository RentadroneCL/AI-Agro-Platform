<?php

namespace App\Http\Livewire;

use App\Models\Site;
use App\Models\Inspection;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\Redirector;

class NewInspectionModalDialog extends Component
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
        'site_id' => '',
        'name' => '',
        'commissioning_date' => '',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.name' => 'required|string|min:6',
        'state.commissioning_date' => 'required|date',
    ];

    /**
     * Indicates if site deletion is being confirmed.
     *
     * @var bool
     */
    public bool $confirmingInspectionCreation = false;

    /**
     * Set the value of the hidden input.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['site_id'] = $this->site->id;
    }

    /**
     * Undocumented function
     *
     * @return Redirector
     */
    public function store(): Redirector
    {
        $this->resetErrorBag();

        $this->validate();

        $inspection = Inspection::create($this->state);

        return redirect()->route('inspection.show', $inspection->fresh());
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.new-inspection-modal-dialog');
    }
}

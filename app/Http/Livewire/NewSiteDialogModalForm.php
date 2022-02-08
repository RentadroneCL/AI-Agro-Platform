<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Site;
use Livewire\Component;
use Livewire\Redirector;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NewSiteDialogModalForm extends Component
{
    /**
     * User model.
     *
     * @var \App\Models\User $user
     */
    public User $user;

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
        'commissioning_date' => '',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.name' => 'required|string|min:6',
        'state.address' => 'required|string|min:6',
        'state.latitude' => 'required|numeric',
        'state.longitude' => 'required|numeric',
        'state.commissioning_date' => 'required|date',
    ];

    /**
     * Indicates if site creation is being confirmed.
     *
     * @var bool
     */
    public bool $confirmingSiteCreation = false;

    /**
     * Set the value of the hidden input.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['user_id'] = $this->user->id;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Redirector
     */
    public function store(): Redirector
    {
        $this->resetErrorBag();

        $this->validate();

        $site = Site::create($this->state);

        return redirect()->route('site.show', $site->fresh());
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.new-site-dialog-modal-form');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\Onboarding as OnboardingProcess;
use App\Notifications\OnboardUserNotification;
use App\Notifications\SuccessfullyOnboardNotification;

class Onboarding extends Component
{
    /**
     * Onboarding model.
     *
     * @var \App\Models\Onboarding $onboarding
     */
    public OnboardingProcess $onboarding;

    /**
     * Toggle success.
     *
     * @var bool
     */
    public bool $success = false;

    /**
     * The component's state.
     *
     * @var array
     */
    public array $state = [
        'user_id' => '',
        'name' => '',
        'position' => '',
        'address' => '',
        'installed_capacity' => '',
        'message' => '',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.name' => 'required|string|min:6',
        'state.position' => 'required|string|min:6',
        'state.address' => 'required|string|min:6',
        'state.installed_capacity' => 'required|numeric',
        'state.message' => 'nullable|string|min:6',
    ];

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listeners = [
        'site-information-saved' => 'setSite',
        'onboarding-process-saved' => 'setOnboarding',
    ];

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['user_id'] = Auth::id();
        $this->state['name'] = Auth::user()->name;
    }

    /**
     * Update state.
     *
     * @return void
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Set site model.
     *
     * @param \App\Models\Site|null $payload
     * @return void
     */
    public function setSite(?Site $payload = null): void
    {
        $this->site = $payload;
    }

    /**
     * Set onboarding model.
     *
     * @param \App\Models\OnboardingProcess|null $payload
     * @return void
     */
    public function setOnboarding(?OnboardingProcess $payload = null): void
    {
        $this->onboarding = $payload;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(): void
    {
        $this->resetErrorBag();

        $this->validate();

        try {
            DB::transaction(function () {
                OnboardingProcess::create($this->state);
                $this->emit('saved');
            });
        } catch (\Throwable $th) {
            $this->emit('transaction-error');
        }
    }

    /**
     * Update onboard record & disable the form.
     *
     * @return void
     */
    public function finish(): void
    {
        Notification::send(Auth::user(), new SuccessfullyOnboardNotification(Auth::user()));

        Notification::route('mail', 'contacto@rentadrone.cl')->notify(new OnboardUserNotification(Auth::user()));

        $this->success = true;

        $this->emit('finish-onboarding');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.onboarding');
    }
}

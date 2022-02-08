<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;

class OnboardingManagement extends Component
{
    /**
     * User model.
     *
     * @var \App\Models\User $user
     */
    public User $user;

    /**
     * Completed mark.
     *
     * @var bool $completed
     */
    public bool $completed = false;

    /**
     * Set component state.
     *
     * @return void
     */
    public function mount(): void
    {
        if ($this->user->onboarding) {
            $this->user->onboarding->completed_at
                ? $this->completed = true
                : $this->completed = false;
        } else {
            $this->completed = false;
        }
    }

    /**
     * Mark as completed button.
     *
     * @return void
     */
    public function markAsCompleted(): void
    {
        $this->user->onboarding()->update([
            'completed_at' => now()->toDateTimeString(),
        ]);

        $this->completed = true;

        $this->emit('saved');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.onboarding-management');
    }
}

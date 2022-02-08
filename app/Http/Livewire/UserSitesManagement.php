<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class UserSitesManagement extends Component
{
    /**
     * User model.
     *
     * @var \App\Models\User $user
     */
    public User $user;

    /**
     * Sites collection.
     *
     * @var \Illuminate\Database\Eloquent\Collection $sites
     */
    public Collection $sites;

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->sites = $this->user->sites;
    }
    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.user-sites-management');
    }
}

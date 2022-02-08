<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Site;
use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Collection;

class SitesTable extends Component
{
    /**
     * User model.
     *
     * @var \App\Models\Site $site
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
        if (Auth::user()->hasRole('administrator')) {
            $this->sites = Site::all();
        } else {
            $this->sites = $this->user->sites;
        }
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sites-table');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class SitesList extends Component
{
    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sites-list', [
            'sites' => Auth::user()->sites()->paginate()
        ]);
    }
}

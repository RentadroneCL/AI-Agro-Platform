<?php

namespace App\Http\Livewire;

use App\Models\Site;
use Illuminate\View\View;
use Livewire\Component;

class SiteCard extends Component
{
    /**
     * Site model.
     *
     * @var \App\Models\Site $site
     */
    public Site $site;

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.site-card');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Site;
use Illuminate\View\View;
use Livewire\Redirector;

class SiteInformationCard extends Component
{
    /**
     * Site model.
     *
     * @var \App\Models\Site $site
     */
    public Site $site;

    /**
     * Indicates if site deletion is being confirmed.
     *
     * @var bool
     */
    public bool $confirmingInspectionCreation = false;

    /**
     * Confirm that the user would like to create a site.
     *
     * @return void
     */
    public function confirmInspectionCreation(): void
    {
        $this->resetErrorBag();

        $this->dispatchBrowserEvent('confirming-create-inspection');

        $this->confirmingSiteDeletion = true;
    }

    /**
     * Undocumented function
     *
     * @return Redirector
     */
    public function store(): Redirector
    {
        redirect('/dashboar');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.site-information-card');
    }
}

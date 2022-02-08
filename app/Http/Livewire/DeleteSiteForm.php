<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Redirector;
use App\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class DeleteSiteForm extends Component
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
    public bool $confirmingSiteDeletion = false;

    /**
     * The user's current password.
     *
     * @var string
     */
    public string $password = '';

    /**
     * Confirm that the user would like to delete their account.
     *
     * @return void
     */
    public function confirmSiteDeletion(): void
    {
        $this->resetErrorBag();

        $this->password = '';

        $this->dispatchBrowserEvent('confirming-delete-site');

        $this->confirmingSiteDeletion = true;
    }

    /**
     * Delete the current site.
     *
     * @return RedirectResponse
     */
    public function destroy(): Redirector
    {
        $this->resetErrorBag();

        if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        $this->site->delete();

        return redirect('/dashboard');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.delete-site-form');
    }
}

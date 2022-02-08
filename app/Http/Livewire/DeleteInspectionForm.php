<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\Redirector;
use Illuminate\View\View;
use App\Models\Inspection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class DeleteInspectionForm extends Component
{
    /**
     * Site model.
     *
     * @var \App\Models\Inspection $inspection
     */
    public Inspection $inspection;

    /**
     * Indicates if inspection deletion is being confirmed.
     *
     * @var bool
     */
    public bool $confirmingInspectionDeletion = false;

    /**
     * The user's current password.
     *
     * @var string
     */
    public string $password = '';

    /**
     * Confirm that the user would like to delete the inspection.
     *
     * @return void
     */
    public function confirmInspectionDeletion(): void
    {
        $this->resetErrorBag();

        $this->password = '';

        $this->dispatchBrowserEvent('confirming-delete-inspection');

        $this->confirmingInspectionDeletion = true;
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

        $this->inspection->delete();

        return redirect('/dashboard');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.delete-inspection-form');
    }
}

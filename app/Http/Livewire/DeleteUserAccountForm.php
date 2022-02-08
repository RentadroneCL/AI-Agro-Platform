<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Redirector;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class DeleteUserAccountForm extends Component
{
    /**
     * User model.
     *
     * @var \App\Models\User $user
     */
    public User $user;

    /**
     * Indicates if site deletion is being confirmed.
     *
     * @var bool
     */
    public bool $confirmingUserAccountDeletion = false;

    /**
     * The user's current password.
     *
     * @var string
     */
    public string $password = '';

    /**
     * Confirm that the user would like to delete the account.
     *
     * @return void
     */
    public function confirmUserAccountDeletion(): void
    {
        $this->resetErrorBag();

        $this->password = '';

        $this->dispatchBrowserEvent('confirming-delete-user-account');

        $this->confirmingUserAccountDeletion = true;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Redirector
     */
    public function destroy(int $id = null): Redirector
    {
        $this->resetErrorBag();

        if (! Hash::check($this->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => [__('This password does not match our records.')],
            ]);
        }

        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('status', __('The record has been deleted!'));

        return redirect()->route('user.index');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.delete-user-account-form');
    }
}

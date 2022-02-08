<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;

class UpdateUserInformationForm extends Component
{
    /**
     * User model.
     *
     * @var \App\Models\User $user
     */
    public User $user;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'name' => '',
        'email' => '',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.name' => 'required|string|min:6',
        'state.email' => 'required|email:rfc,dns|unique:users,email',
    ];


    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['name'] = $this->user->name;
        $this->state['email'] = $this->user->email;
    }

    /**
     * Update the specified resource in storage.
     *
     * @return void
     */
    public function update(): void
    {
        $this->resetErrorBag();

        $this->validate();

        $this->user->update($this->state);

        $this->emit('saved');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.update-user-information-form');
    }
}

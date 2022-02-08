<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;

class SyncUserRolesForm extends Component
{
    /**
     * User model.
     *
     * @var \App\Models\User $user
     */
    public User $user;

    /**
     * Roles collection.
     *
     * @var \Illuminate\Database\Eloquent\Collection $roles
     */
    public Collection $roles;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [
        'roles' => [],
    ];

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->roles = Role::all();

        $this->state['roles'] = $this->user->roles->pluck('id')->map(fn($item) => strval($item))->toArray();
    }

    /**
     * Sync user roles.
     *
     * @return void
     */
    public function update(): void
    {
        $this->resetErrorBag();

        $this->user->roles()->sync($this->state['roles']);

        $this->emit('saved');
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sync-user-roles-form');
    }
}

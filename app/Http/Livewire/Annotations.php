<?php

namespace App\Http\Livewire;

use App\Models\Annotation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Annotations extends Component
{
    /**
     * The given model
     *
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    public Model $model;

    /**
     * Annotations collection
     *
     * @var \Illuminate\Database\Eloquent\Collection $annotations
     */
    public Collection $annotations;

    /**
     * The component's state.
     *
     * @var array
     */
    public array $state = [
        'user_id' => '',
        'content' => '',
        'custom_properties' => null,
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.content' => 'required|string',
        'state.custom_properties' => 'nullable|string',
    ];

    /**
     * Set component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['user_id'] = Auth::id();
    }

    public function create(): Annotation
    {

    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.annotations');
    }
}

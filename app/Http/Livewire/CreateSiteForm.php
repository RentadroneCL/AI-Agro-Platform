<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;

class CreateSiteForm extends Component
{
    /**
     * The component's state.
     *
     * @var array
     */
    public array $state = [
        'user_id' => '',
        'name' => '',
        'address' => '',
        'latitude' => '',
        'longitude' => '',
        'commissioning_date' => ''
    ];

    public function mount()
    {
        $this->state['user_id'] = Auth::id();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->resetErrorBag();

        $this->state['user_id'] = Auth::id();

        $newSite = Site::create($this->state);

        return redirect()->route('site.show', $newSite->refresh());
    }

    public function render()
    {
        return view('livewire.create-site-form');
    }
}

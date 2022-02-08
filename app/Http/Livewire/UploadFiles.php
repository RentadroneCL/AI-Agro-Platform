<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use App\Models\Inspection;

class UploadFiles extends Component
{
    /**
     * Inspection model.
     *
     * @var \App\Models\Inspection $inspection
     */
    public Inspection $inspection;

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('livewire.upload-files');
    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Overview extends Component
{
    /**
     * The given model
     *
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    public Model $model;

    /**
     * Files collection.
     *
     * @var mixed $files
     */
    public $files;

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $files = $this->model->getMedia('orthomosaic-geojson')
            ->filter(fn($file) => in_array($file->mime_type, ['application/json', 'text/plain']))
            ->map(function ($item) {
                return (object) [
                    'id' => $item->id,
                    'file_name' => $item->file_name,
                    'mime_type' => $item->mime_type,
                    'url' => Storage::temporaryUrl($item->getPath(), Carbon::now()->addMinutes(60)),
                ];
            });

        $this->files = $files;
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.overview');
    }
}

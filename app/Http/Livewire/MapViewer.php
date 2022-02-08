<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class MapViewer extends Component
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
     * Event Listeners
     *
     * @var array $listeners
     */
    protected $listeners = [
        'complete-files-upload' => 'updateFilesCollection',
        'deleted-media' => '$refresh'
    ];

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->files = [
            'geotiff' => $this->files->filter(fn($file) => in_array($file->mime_type, ['image/tiff'])),
            'geojson' => $this->files->filter(fn($file) => in_array($file->mime_type, ['application/json', 'text/plain'])),
        ];
    }

    /**
     * Update files collection
     *
     * @return void
     */
    public function updateFilesCollection(): void
    {
        $collection = $this->model->media()->where([
            'collection_name' => 'orthomosaic-geojson',
            'mime_type' => 'image/tiff',
        ])->get();

        $this->files = [
            'geotiff' => $collection->filter(fn($file) => in_array($file->mime_type, ['image/tiff'])),
            'geojson' => $collection->filter(fn($file) => in_array($file->mime_type, ['application/json', 'text/plain'])),
        ];
    }

    /**
     * Render the component.
     *
     * @return void
     */
    public function render(): View
    {
        return view('livewire.map-viewer');
    }
}

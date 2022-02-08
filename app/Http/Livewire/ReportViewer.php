<?php

namespace App\Http\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

class ReportViewer extends Component
{
    /**
     * The given model
     *
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    public Model $model;

    /**
     * Inspection model.
     *
     * @var \Illuminate\Support\Collection $files
     */
    public Collection $files;

    /**
     * Event Listeners
     *
     * @var array $listeners
     */
    protected $listeners = [
        'complete-files-upload' => 'updateFilesCollection',
        'deleted-media' => 'updateFilesCollection'
    ];

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->files = $this->files->filter(fn($file) => $file->collection_name === 'pdf');

        // dd($this->files);
    }

    /**
     * Update files collection
     *
     * @return void
     */
    public function updateFilesCollection(): void
    {
        $this->files = $this->model->media()
            ->where(['collection_name' => 'pdf', 'mime_type' => 'application/pdf'])
            ->get();
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.report-viewer');
    }
}

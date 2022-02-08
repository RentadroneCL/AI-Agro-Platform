<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class FilesTable extends Component
{
    /**
     * The given model
     *
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    public Model $model;

    /**
     * Files collection
     *
     * @var \Illuminate\Database\Eloquent\Collection $files
     */
    public Collection $files;

    /**
     * Indicates if media deletion is being confirmed.
     *
     * @var bool $confirmingMediaDeletion
     */
    public bool $confirmingMediaDeletion = false;

    /**
     * The current media deletion id.
     *
     * @var null|int $mediaId
     */
    public ?int $mediaId = null;

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
     * Set component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->files = $this->model->media()->get();
    }

    /**
     * Confirm that the user would like to delete the media resource.
     *
     * @return void
     */
    public function confirmMediaDeletion(int $id = null): void
    {
        $this->dispatchBrowserEvent('confirming-delete-media');

        $this->confirmingMediaDeletion = true;

        $this->mediaId = $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return void
     */
    public function destroy(): void
    {
        $this->resetErrorBag();

        $media = Media::findOrFail($this->mediaId);

        $media->delete();

        $this->confirmingMediaDeletion = false;

        $this->emit('deleted-media', $this->mediaId);

        $this->mediaId = null;
    }

    /**
     * Update files collection
     *
     * @return void
     */
    public function updateFilesCollection(): void
    {
        $this->files = $this->model->media()->get();
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.files-table');
    }
}

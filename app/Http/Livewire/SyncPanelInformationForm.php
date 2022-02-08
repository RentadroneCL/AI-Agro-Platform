<?php

namespace App\Http\Livewire;

use App\Models\Panel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Livewire\Component;

class SyncPanelInformationForm extends Component
{
    /**
     * Indicates if panel creation is being confirmed.
     *
     * @var bool
     */
    public bool $displayPanelCreationForm = true;

    /**
     * The given model
     *
     * @var \Illuminate\Database\Eloquent\Model $model
     */
    public Model $model;

    /**
     * Panel type.
     *
     * @var \Illuminate\Database\Eloquent\Collection $panelTypes
     */
    public Collection $panelTypes;

    /**
     * The component's state.
     *
     * @var array
     */
    public array $state = [
        'site_id' => '',
        'panel_id' => '',
        'panel_serial' => '',
        'panel_zone' => null,
        'panel_sub_zone' => null,
        'panel_string' => null,
        'custom_properties' => null,
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.site_id' => 'required|integer',
        'state.panel_id' => 'required|string',
        'state.panel_serial' => 'required|string|min:1',
        'state.panel_zone' => 'nullable|string',
        'state.panel_sub_zone' => 'nullable|string',
        'state.panel_string' => 'nullable|string',
        'state.custom_properties' => 'nullable|json',
    ];

    /**
     * Event listeners.
     *
     * @var array
     */
    protected $listeners = [
        'panel-info' => 'checkingForPanelExistence',
    ];

    /**
     * Set component state.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->state['site_id'] = $this->model->site->id;
    }

    /**
     * Check if panel exist.
     *
     * @param array|null $payload
     * @return Panel|JsonResponse
     */
    public function checkingForPanelExistence(array $payload = null): Panel|JsonResponse
    {
        $this->state = $payload;
        $this->state['site_id'] = $this->model->site->id;

        try {
            $panel = Panel::query()
                ->where([
                    'site_id' => $this->state['site_id'],
                    'panel_id' => $this->state['panel_id'],
                    'panel_serial' => $this->state['panel_serial'],
                ])
                ->get();

            $panel->count() > 0
                ? ($this->displayPanelCreationForm = true)
                : ($this->displayPanelCreationForm = false);

            return $panel;

        } catch (\Throwable $th) {
            return response()->json([
                'message' => '__("The requested resource doesn\'t exist.")',
                'payload' => $payload,
                'status' => 'error',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Panel|JsonResponse
     */
    public function store(): Panel|JsonResponse
    {
        $this->resetErrorBag();

        $this->validate();

        try {
            $panel = Panel::create($this->state);

            $this->displayPanelCreationForm = false;

            $this->emit('saved');

            $this->state = [
                'panel_id' => '',
                'panel_serial' => '',
                'panel_zone' => null,
                'panel_sub_zone' => null,
                'panel_string' => null,
                'custom_properties' => null,
            ];

            return $panel;

        } catch (\Throwable $th) {

            $this->displayPanelCreationForm = true;

            $this->emit('error');

            return response()->json([
                'message' => '__("Something went wrong")',
                'payload' => $this->state,
                'status' => 'error',
            ], 500);
        }
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sync-panel-information-form');
    }
}

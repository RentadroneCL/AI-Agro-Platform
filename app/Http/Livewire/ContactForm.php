<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactSupportNotification;

class ContactForm extends Component
{
    /**
     * The component state.
     *
     * @var array $state
     */
    public array $state = [
        'name' => '',
        'email' => '',
        'phone' => '',
        'type' => '',
        'subject' => '',
        'message' => '',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected array $rules = [
        'state.name' => 'required|string|min:6',
        'state.email' => 'required|email',
        'state.phone' => 'required|string|min:6',
        'state.type' => 'required|string|min:6',
        'state.subject' => 'required|string|min:6',
        'state.message' => 'required|string|min:6',
    ];

    /**
     * Set the component state.
     *
     * @return void
     */
    public function mount(): void
    {
        if (Auth::user()) {
            $this->state['name'] = Auth::user()->name;
            $this->state['email'] = Auth::user()->email;
        }
    }

    /**
     * Updated state.
     *
     * @param mixed $propertyName
     *
     * @return void
     */
    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Support notification.
     *
     * @return void
     */
    public function sendMessage(): void
    {
        $this->resetErrorBag();

        Notification::route('mail', 'contacto@rentadrone.cl')->notify(
            new ContactSupportNotification($this->state)
        );

        $this->emit('sent');

        $this->state = [
            'name' => Auth::user()->name ?? '',
            'email' => Auth::user()->email ?? '',
            'phone' => '',
            'type' => '',
            'subject' => '',
            'message' => '',
        ];
    }

    /**
     * Render the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('livewire.contact-form');
    }
}

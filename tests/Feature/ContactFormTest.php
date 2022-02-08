<?php

use App\Models\User;
use App\Http\Livewire\ContactForm;
use App\Http\Livewire\ContactFormDialogModal;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\AnonymousNotifiable;
use App\Notifications\ContactSupportNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('an authenticated user can send a contact notification', function () {
    Notification::fake();

    $this->actingAs($user = User::factory()->create())
        ->livewire(ContactForm::class)
        ->assertViewIs('livewire.contact-form')
        ->set('state.phone', '+1 800 444 4444')
        ->set('state.type', 'Other')
        ->set('state.subject', 'Testing component field')
        ->set('state.message', 'Testing component field')
        ->call('sendMessage')
        ->assertEmitted('sent');

    Notification::assertSentTo(
        new AnonymousNotifiable, ContactSupportNotification::class
    );
});

test('an unauthenticated user can send a contact notification', function () {
    Notification::fake();

    $this->assertGuest($guard = null)
        ->livewire(ContactForm::class)
        ->assertViewIs('livewire.contact-form')
        ->set('state.name', 'Jane Doe')
        ->set('state.email', 'jane.doe@example.com')
        ->set('state.phone', '+1 800 444 4444')
        ->set('state.type', 'Other')
        ->set('state.subject', 'Testing component field')
        ->set('state.message', 'Testing component field')
        ->call('sendMessage')
        ->assertEmitted('sent');

    Notification::assertSentTo(
        new AnonymousNotifiable, ContactSupportNotification::class
    );
});

it('has a contact support dialog modal', function () {
    Notification::fake();

    $this->actingAs($user = User::factory()->create())
        ->livewire(ContactFormDialogModal::class)
        ->assertViewIs('livewire.contact-form-dialog-modal')
        ->set('state.phone', '+1 800 444 4444')
        ->set('state.type', 'Other')
        ->set('state.subject', 'Testing component field')
        ->set('state.message', 'Testing component field')
        ->call('sendMessage')
        ->assertEmitted('sent');

    Notification::assertSentTo(
        new AnonymousNotifiable, ContactSupportNotification::class
    );
});

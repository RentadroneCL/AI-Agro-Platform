<?php

use App\Models\Site;
use App\Http\Livewire\SiteCard;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has site card component', function () {
    $site = Site::factory()->create();

    $this->actingAs($site->user)
        ->livewire(SiteCard::class, ['site' => $site])
        ->assertViewIs('livewire.site-card');
});

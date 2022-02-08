<?php

it('has inspectionform page', function () {
    $response = $this->get('/inspectionform');

    $response->assertStatus(200);
})->skip();

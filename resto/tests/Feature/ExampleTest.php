<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/'); /* On appel cette route */

        $response->assertSeeText('Bienvenue au Resto à déjeuner');  /* On analyse la réponse -> vérifier qu'il y a un H1 */
        $response->assertStatus(200);
    }
}

<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp(); // Doit être à la première ligne

        // Code ici exemple:
        $this->seed("MenuSeeder");

        // Créer un utilisateur
        $this->user = factory(User::class)->create([
            'birthdate' => now()->subYear(20),
            // À continer
        ]);
    }
   
    public function test_is_adult():void 
    {
        //Si on n'utilise pas la méthode setUp
        $this->user = factory(User::class)->create([
            'birthdate' => now()->subYears(20),
        ]);
        // Vérifier si l'utilisateur est majeur
        $this->assertTrue($this->user->isAdult());
    }

    public function tearDown():void
    {
        // code ici

        parent::tearDown(); // Doit être la dernière ligne
    }
}

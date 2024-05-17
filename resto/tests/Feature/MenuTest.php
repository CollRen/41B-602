<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\Rules\ImageFile;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;
use App\Models\Menu;
use App\Models\User;

/**!SECTION
 * Lister ce qu'on l'on veut test pour chaque section
 * 1. Show
 *  1.1
 *  1.2
 *  1.3
 * 2. Formulaire
 *  2.1
 *  2.2
 *  etc.
 * 3. Routes
 */
class MenuTest extends TestCase
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
    /**
     * Tester la page catalogue de notre menu
     * 1. Que la route existe, code 200 et est afficher correctement
     */
    public function test_menu_index_valid(): void
    {
        $response = $this->get(route("menus.index")); /* On appel cette route */

        /**
         * Est-ce qu'on a passer une variable
         * Tester la route, le code, les données
         * @var 'title' 
         * @var $menus
         */
        $response->assertViewHas('menus');  /* On analyse la réponse -> La vue contient cette variable */
        $response->assertViewHas('title');  
        /* $response->assertViewHas('exitePas'); */ /*   Failed asserting that false is true. !SECTION➜  25▕ $response->assertViewHas('exitePas'); */
        $response->assertStatus(200);
    }

    /** $menuQuery
     *
     *   
     */
    public function test_index_contains_menu()
    {
        $response = $this->get(route("menus.index")); /* On appel cette route */
/* Récupérer les datas de la bd */
        /* $menuData = $response->getOriginalContent() */ /* Récupérer les datas de la bd */
        $menuData = $response->original->getData()['menus']; /* Récupérer les datas de la bd */
       /*  $this->assertCount();  *//* Pour un nombre exacte */
        $this->assertGreaterThan(0, count($menuData));


        /* Vérifier qu'il y a minimalement 1 produit */
        /* Vérifier qu'il y a minimalement 1 produit */
        /* Vérifier qu'il y a un menu */

    }

    public function test_index_trier_prix_desc():void
    {
        $response = $this->get(route("menus.index", ['tri' => 'prix', 'direction' => 'desc'])); /* Le deuxième arg: params que je veux passer */
        $menuData = $response->original->getData()['menus'];
        $prixFirst = $menuData->first()->prix;
        $prixLast = $menuData->last()->prix;
        $this->assertGreaterThanOrEqual($prixLast, $prixFirst, 'test_index_trier_prix_desc');
        // $response->assertStatus(200);
    }

    public function test_page_inconnue():void
    {
        $response = $this->get("/asdfdfhadrf");
        $response->assertStatus(404);
    }

    public function test_menu_show():void
    {
        $menu = Menu::first();
        $response = $this->get(route("menus.show", ['menu' => $menu->id]));
        // TBC
    }

    public function test_menu_create():void
    {
        $response = $this->get(route("menus.create"));
        $response->assertElementExists("form");
        $response->assertElementExists("input[name='nom']");
        $response->assertElementExists("input[name='prix']");
        // TBC

    }

    public function test_login_form():void
    {
        $image = new ImageFile();
        $response = $this->post(route('menus.store', [
            // Tous les champs que j'envoies: nom, image, si c'est valide, etc.
            "nom" => "MenuTest3c",
            "prix" => 10,
            "estVego" => false,
            "description" => "Lorem Ipsum",
            "image" => $image
        ]));

        $response->assertStatus(302); // Redirection
        $response->assertRedirect(route("menus.index")); // Diriger correctement

        /* Clean up automatique */

        Menu::orderByDesc('id')->first()->delete();
    }

    public function test_print_end_message():void
    {
        print "S'il vous plait nettoyer la base de données après vos tests";
    }

    public function tearDown():void
    {
        // code ici

        parent::tearDown(); // Doit être la dernière ligne de cette fonction
    }
}

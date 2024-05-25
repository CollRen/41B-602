<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nouveauMenu = new Menu();

        session()->put("panier", ["patate", $nouveauMenu]);//Reste pour toutes les requêtes
        session()->flash("panier2", ["patate", $nouveauMenu]);//Pratique pour erreur ou message de succes. pour une requête
        // Log::info($request->url());
        // Log::warning("Message d'avertissement");
        // Log::error("Erreur");
        // abort(419, "Message personnalisé");

        //On récupère le queryString de la requête donc de l'url Ex: www.patate.com?tri=nom&direction=asc
        $tri = $request->query('tri', 'titre');
        $direction = $request->query('direction', 'asc');
        $prixMax = $request->query("prix-max");
        $categorie = $request->query("category");

        //Query démare une demande au modèle et doit finir avec get()
        $menuQuery = Menu::query();
        if ($categorie) {
            $menuQuery = $menuQuery->where("categorie_id", $categorie);
        }

        // dd($menuQuery);
        $menuQuery->orderBy($tri, $direction);

        if ($prixMax) {
            $menuQuery->where("prix", "<", $prixMax);
        }

        // On remplace le get par paginate
        // $menus = $menuQuery->get(); 

        // Paginate ajoute la méthode links dans Blade
        $menus = $menuQuery->simplePaginate(6)->withQueryString();


        $categories = Categorie::all();
        $tests = $categories->first()->menus;
        // dd($tests);
        // dd($menus->first()->categorie->nom);
        return view("menus.index", ["menus" => $menus, "title" => "Menus du resto", "categories" => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // dd(session()->all());
        return view("menus.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMenuRequest $request)
    {
        //Tableau contenant les champs validés et nettoyés
        $validated = $request->validated();

        // Création d'une nouvelle instance de Menu
        $nouveauMenu = new Menu();
        // Remplissage de l'instance de Menu avec les données de la requête
        $nouveauMenu->fill($validated);

        if ($request->image) {
            $path = $request->image->store("menus", "public");
            $nouveauMenu->image = $path;
        }

        // Conversion de la valeur de la clé "estVege" en boolean
        $nouveauMenu->estVege = $request->boolean("estVege");

        // Utilisation d'un bloc try/catch pour gérer les erreurs potentielles lors de l'enregistrement du Menu
        $nouveauMenu->save();

        // Si tout se passe bien, redirection vers l'index des menus
        return redirect()->route("menus.index")->with("success", "Le menu a été ajouté");
    }


    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $patate = session()->get("panier");
        session()->forget("panier");
        // dd($patate);
        return view("menus.menu", ["menu" => $menu, "title" => $menu->nom]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMenuRequest $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        //
    }
}

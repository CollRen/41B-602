<?php

namespace App\Http\Controllers;

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

        /**!SECTION
         * Stockage d'infos dans l'objet session
         * Voir /MenuController/show() pour le get()
         */
        session()->put("Suivra", "Toujous");
        /**!SECTION
         * Pratique pour message court pour un seul affichage
         */
        session()->flash("seraEffacé", "AffichéSeulementUnePage");

        session()->forget("Suivra");


        // Log::info($request->url());
        // Log::warning("Message d'avertissement");
        // Log::error("Erreur");
        // abort(419, "Message personnalisé");
        // try {
        //     throw new Exception("Patate");
        // } catch (Exception $e) {
        //     Log::warning($e->getMessage());
        //     return back()->with("erreur", $e->getMessage());
        // }
        //On récupère le queryString de la requête donc de l'url Ex: www.patate.com?tri=nom&direction=asc
        $tri = $request->query('tri', 'nom');
        $direction = $request->query('direction', 'asc');
        $prixMax = $request->query("prix-max");

        //Query démare une demande au modèle et doit finir avec get()
        $menuQuery = Menu::query();
        $menuQuery->orderBy($tri, $direction);

        if ($prixMax) {
            $menuQuery->where("prix", "<", $prixMax);
        }

        $menus = $menuQuery->get();

        return view("menus.index", ["menus" => $menus, "title" => "Menus du resto"]);
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

        // Conversion de la valeur de la clé "estVege" en boolean
        $nouveauMenu->estVege = $request->boolean("estVege");

        if ($request->image) {

            $path = $request->image->store("menus", "public");
            $nouveauMenu->image = imageFullPath();
        }

        // Utilisation d'un bloc try/catch pour gérer les erreurs potentielles lors de l'enregistrement du Menu
        $nouveauMenu->save();

        // Si tout se passe bien, redirection vers l'index des menus
        // with ajoute sa clé, valeur dans la session();
        return redirect()->route("menus.index")->with("success", "Le menu a été ajouté");
    }


    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        /**!SECTION
         * Comment aller chercher ce qui se trouve dans session()
         */
        /*
            $Suivra = session()->get("Suivra");
            dd($Suivra); 
        */
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

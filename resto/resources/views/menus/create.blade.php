@extends('partials.base')

@section('title', 'Ajouter un menu')

@section('content')
    <main class="flex-auto flex flex-col justify-center align-center text-center gap-5 bg-white ">
        <h1 class="text-lg">Ajouter un menu</h1>

        <form action="{{ route('menus.store') }}" enctype="multipart/form-data" method="POST">
            @csrf
            {{-- @method("PUT") --}}
            <div class="my-2">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" class="border-2" accept="image/*, image/jpeg"
                    {{-- value="{{ old("image") }}" --}}>
                @error('image')
                    <p class="text-red-900 text-lg">{{ $message }}</p>
                @enderror
            </div>

            <div class="my-2">
                <label for="nom">Nom</label>
                <input type="text" name="nom" id="nom" class="border-2" value="{{ old('nom') }}">
                @error('nom')
                    <p class="text-red-900 text-lg">{{ $message }}</p>
                @enderror
            </div>
            <div class="my-2">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="border-2">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-900 text-lg">{{ $message }}</p>
                @enderror
            </div>

            <div class="my-2">
                <label for="prix">Prix</label>
                <input type="number" name="prix" id="prix" class="border-2" value="{{ old('prix') }}">
                @error('prix')
                    <p class="text-red-900 text-lg">Vous devez fournir un prix</p>
                @enderror
            </div>

            <div class="my-2">
                <label for="estVege">Est végétarien?</label>
                <input type="checkbox" name="estVege" id="estVege" value=1 {{ old('estVege') ? 'checked="checked"' : '' }}
                    class="border-2">

                @error('estVege')
                    <p class="text-red-900 text-lg">Il y a une erreur dans le champ</p>
                @enderror
            </div>
            <button class="bg-amber-700 text-white p-5 rounded-lg" type="submit">Envoyer</button>
        </form>
    </main>
@endsection

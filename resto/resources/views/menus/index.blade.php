@extends('partials.base')

@section('title', $title)

@section('content')
    @if (session('success'))
        <x-alert :type="'success'">
            {{ session('success') }}
        </x-alert>
    @endif
    @if (session('erreur'))
        <x-alert :type="'danger'">
            {{ session('erreur') }}
        </x-alert>
    @endif
    @if ($menus->isEmpty())
        <x-alert :type="'danger'">
            Vous n'avez aucun menu à afficher
        </x-alert>
    @endif
    <main class="flex-auto flex flex-col justify-center align-center text-center gap-5 "
        style="background:linear-gradient(to left, rgba(0,0,0,0.5) 0%, rgba(0,0,0,0.5) 100%), url({{ Vite::asset('resources/img/banniere.jpeg') }}); background-size:cover, cover;">
        <div class="flex justify-center my-3">
            <a class="p-3 rounded-lg bg-amber-500 text-amber-950"
                href="{{ route('menus.index', ['tri' => 'prix', 'direction' => 'desc']) }}">Par prix
                descendant</a>
            <a class="p-3 rounded-lg bg-amber-500 text-amber-950"
                href="{{ route('menus.index', ['tri' => 'nom', 'direction' => 'asc']) }}">Par nom
                ascendant</a>
            <a class="p-3 rounded-lg bg-amber-500 text-amber-950"
                href="{{ route('menus.index', ['tri' => 'prix', 'direction' => 'asc', 'prix-max' => 10]) }}">Spéciaux de la
                fin de semaine</a>
        </div>
        {{-- bg-amber-100 text-amber-900 z-10 basis-1/4 flex flex-col gap-3 --}}
        <section class="flex flex-wrap gap-3 justify-center items-center">
            @forelse ($menus as $menu)
                <a href="{{ route('menus.show', ['menu' => $menu->id]) }}" @class([
                    'text-amber-900 z-10 basis-1/4 bg-amber-500',
                    'bg-blue-500 text-white' => $menu->prix > 10,
                ])>
                    @if ($menu->image)
                        <img src="/storage/{{ $menu->image }}" alt="Image pour {{ $menu->nom }}">
                        
                    @else
                        <img src="/assets/img/banniere.jpeg" alt="Image pour {{ $menu->nom }}">
                    @endif
                    <p>{{ $menu->nom }}</p>
                    <p>{{ $menu->prix }}</p>
                    <p>{{ $menu->description }}</p>
                </a>

            @empty
                <p class="bg-amber-50 p-12 self-center text-lg rounded-lg">Aucun menu</p>
            @endforelse
        </section>
    </main>

@endsection

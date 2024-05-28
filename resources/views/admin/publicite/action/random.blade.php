@extends('admin')

@php
$titre = "";
if(request()->routeIs('Administration.Publiciter.creer_une_publiciter')) {
    $titre = "Creation d'une publicite";
} else {
    $titre = "Modification d'une publicite";
}
@endphp
@section('titre', $titre)

@section('pagetitle')
<div class="pagetitle">
    <h1>Publicité</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Publicité</li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.Publiciter.liste_publicite')}}">Liste</a>
        </li>
        <li class="breadcrumb-item active">
            {{$titre}}
        </li>
      </ol>
    </nav>
  </div>
@endsection

@section('contenu')
@if (session('succes'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{session('succes')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if (session('erreur'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{session('erreur')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<div class="alert alert-danger text-center">

</div>
@endif
@if (session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{session('warning')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


@if(request()->routeIs('Administration.Publiciter.creer_une_publiciter'))

<div class="container">
    <form action="" method="post">
        @csrf
        {{-- Titre --}}
        <label for="titre">Titre de la publicité</label>
        <input type="text" name="titre" id="titre" class="form-control" value="{{@old('titre')}}">
        @error('titre')
            <p style="color: red">
                {{$message}}
            </p>
        @enderror

        {{-- description --}}
        <label for="description_pub">Description de la publicité</label>
        <input type="text" name="description_pub" id="description_pub" class="form-control" value="{{@old('description_pub')}}">
        @error('description_pub')
            <p style="color: red">
                {{$message}}
            </p>
        @enderror

        {{-- Contenu pub --}}
        <label for="contenu_pub">Contenu de la publicité</label>
        <textarea class="form-control" name="contenu_pub" id="contenu_pub" cols="30" rows="10">
            {{@old('contenu_pub')}}
        </textarea>
        @error('contenu_pub')
            <p style="color: red">
                {{$message}}
            </p>
        @enderror

        <button type="submit" class="btn btn-primary" style="margin-top: 15px; width: 100%">
            Enregistrer
        </button>
    </form>
</div>

@else
<form action="" method="post">
    @csrf
    @method('PUT')
    {{-- Titre --}}
    <label for="titre">Titre de la publicité</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{$publicite->titre}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- description --}}
    <label for="description_pub">Description de la publicité</label>
    <input type="text" name="description_pub" id="description_pub" class="form-control" value="{{$publicite->description_pub}}">
    @error('description_pub')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- Contenu pub --}}
    <label for="contenu_pub">Contenu de la publicité</label>
    <textarea class="form-control" name="contenu_pub"  id="contenu_pub" cols="30" rows="10" >
        {{$publicite->contenu_pub}}
    </textarea>
    @error('contenu_pub')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    <button type="submit" class="btn btn-primary" style="margin-top: 15px; width: 100%">
        Enregistrer
    </button>
</form>

@endif

@endsection

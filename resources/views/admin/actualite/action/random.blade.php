@extends('admin')

@php
$titre = "";
if(request()->routeIs('Administration.Actualite.creer_actualite')) {
    $titre = "Creation d'une actualité";
} else {
    $titre = "Modification d'une actualité";
}
@endphp
@section('titre', $titre)

@section('pagetitle')
<div class="pagetitle">
    <h1>
        Actualité
    </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Actualité
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.Actualite.liste_des_actualite')}}">Liste</a>
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

@if(request()->routeIs('Administration.Actualite.creer_actualite'))

<form action="" method="post" enctype="multipart/form-data">
    @csrf
    {{-- titre --}}
    <label for="titre">Titre de l'actualité</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{@old('titre')}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- description --}}
    <label for="description">Description de l'actualité</label>
    <input type="text" name="description" id="description" class="form-control" value="{{@old('description')}}">
    @error('description')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- contenu --}}
    <label for="contenu">Contenu de l'actualité</label>
    <textarea name="contenu" id="contenu" class="form-control" cols="30" rows="10">
        {{@old('contenu')}}
    </textarea>
    @error('contenu')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- media --}}
    <label for="media">Media de l'actualité</label>
    <input type="file" name="media" id="media" class="form-control">
    @error('media')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    <input type="submit" value="Enregistrer" class="btn btn-primary" style="width: 100%; margin-top:15px">
</form>

@else

<form action="" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    {{-- titre --}}
    <label for="titre">Titre de l'actualité</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{$actualite->titre}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- description --}}
    <label for="description">Description de l'actualité</label>
    <input type="text" name="description" id="description" class="form-control" value="{{$actualite->description}}">
    @error('description')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror
    {{-- contenu --}}
    <label for="contenu">Contenu de l'actualité</label>
    <textarea name="contenu" id="contenu" class="form-control" cols="30" rows="10">
        {{$actualite->contenu}}
    </textarea>
    @error('contenu')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- media --}}
    <div class="row mb-3">
        <div class="col md-6">
            <label for="media">Media de l'actualité</label>
            <input type="file" name="media" id="media" class="form-control">
            @error('media')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror
        </div>
        <div class="col md-6">
            <img src="/storage/{{$actualite->media}}" alt="{{$actualite->titre}}" style="width: 100%;margin-top:15px">
        </div>
    </div>

    <input type="submit" value="Enregistrer" class="btn btn-primary" style="width: 100%; margin-top:15px">
</form>

@endif


@endsection

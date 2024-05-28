@extends('admin')

@php
$titre = "";
if(request()->routeIs('Administration.Portfolio.Categorie.creer_categorie_portfolio')) {
    $titre = "Creation d'une catégorie de portfolio";
} else {
    $titre = "Modification d'une catégorie de portfolio";
}
@endphp
@section('titre', $titre)
@section('pagetitle')
<div class="pagetitle">
    <h1>
        Portfolio
    </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Catégorie de portfolio
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.Portfolio.Categorie.liste_category_portfolio')}}">Liste</a>
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

@if (request()->routeIs('Administration.Portfolio.Categorie.creer_categorie_portfolio'))
    <form action="" method="post">
        @csrf
        <label for="titre">Nom du catégorie</label>
        <input type="text" name="titre" id="titre" class="form-control" value="{{@old('titre')}}">
        @error('titre')
            <p style="color: red">
                {{$message}}
            </p>
        @enderror
        <input type="submit" value="Enregistrer" class="btn btn-primary" style="width: 100%; margin-top:15px">
    </form>
@else
<form action="" method="post">
    @csrf
    @method('PUT')
    <label for="titre">Nom du catégorie</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{$categorie->titre}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror
    <input type="submit" value="Enregistrer" class="btn btn-primary" style="width: 100%; margin-top:15px">
</form>
@endif

@endsection

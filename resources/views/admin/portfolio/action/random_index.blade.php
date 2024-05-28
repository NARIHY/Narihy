@extends('admin')

@php
$titre = "";
if(request()->routeIs('Administration.Portfolio.MesPortfolio.ajouter_portfolio')) {
    $titre = "Ajout d'une  portfolio";
} else {
    $titre = "Modification d'une  portfolio";
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
            Portfolio
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.Portfolio.MesPortfolio.lister_portfolio')}}">Liste</a>
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

{{--


'titre',
        'description',
        'contenu',
        'lien_portfolio',
        'media',
        'status',
        'users_id',
        'category_portfolio_id'
--}}
@if (request()->routeIs('Administration.Portfolio.MesPortfolio.ajouter_portfolio'))
<form action="" method="post" enctype="multipart/form-data">
    @csrf
    {{-- Titre du portfolio  --}}
    <label for="titre">Titre du portfolio:</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{@old('titre')}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- description --}}
    <label for="description">Description du portfolio:</label>
    <input type="text" name="description" id="description" class="form-control" value="{{@old('description')}}">
    @error('description')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- lien du portfolio --}}
    <label for="lien_portfolio">Lien du portfolio:</label>
    <input type="text" name="lien_portfolio" id="lien_portfolio" class="form-control" value="{{@old('lien_portfolio')}}">
    @error('lien_portfolio')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- media --}}
    <label for="media">Media du portfolio:</label>
    <input type="file" name="media" id="media" class="form-control">
    @error('media')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror
    {{-- Tsy hitany ity --}}
    <label for="category_portfolio_id">Catégorie du portfolio: </label>
    <select name="category_portfolio_id" id="category_portfolio_id" class="form-control">
        <option value="">Selectionner une ou plusieurs catégorie</option>
        @foreach ($category as $k => $v)
            <option value="{{$v}}">
                {{$k}}
            </option>
        @endforeach
    </select>

    @error('category_portfolio_id')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    <label for="contenu">Contenu du portfolio</label>
    <textarea name="contenu" id="contenu" class="form-control" cols="30" rows="10">
        {{@old('contenu')}}
    </textarea>
    @error('contenu')
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

    {{-- Titre du portfolio  --}}
    <label for="titre">Titre du portfolio:</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{$portfolio->titre}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- description --}}
    <label for="description">Description du portfolio:</label>
    <input type="text" name="description" id="description" class="form-control" value="{{$portfolio->description}}">
    @error('description')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- lien du portfolio --}}
    <label for="lien_portfolio">Lien du portfolio:</label>
    <input type="text" name="lien_portfolio" id="lien_portfolio" class="form-control" value="{{$portfolio->lien_portfolio}}">
    @error('lien_portfolio')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- media --}}
    <div class="row mb-3" style="margin-top: 15px">
        <div class="col md-6">
            <label for="media">Media du portfolio:</label>
            <input type="file" name="media" id="media" class="form-control">
            @error('media')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror
        </div>
        <div class="col md-6">
            <img src="/storage/{{$portfolio->media}}" alt="{{$portfolio->titre}}" width="100%">
        </div>
    </div>

    <label for="category_portfolio_id">Catégorie du portfolio: </label>
    <select name="category_portfolio_id" id="category_portfolio_id" class="form-control" >
        <option value="">Selectionner une catégorie</option>
        @foreach ($category as $k => $v)
            <option value="{{$v}}" @if($portfolio->category_portfolio_id === $v) selected  @endif>
                {{$k}}
            </option>
        @endforeach
        {{-- multiple --}}

    </select>

    <label for="contenu">Contenu du portfolio</label>
    <textarea name="contenu" id="contenu" class="form-control" cols="30" rows="10">
        {{$portfolio->contenu}}
    </textarea>
    @error('contenu')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    <input type="submit" value="Enregistrer" class="btn btn-primary" style="width: 100%; margin-top:15px">
</form>

@endif

@endsection

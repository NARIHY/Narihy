@extends('admin')
@php
$titre = "";
if(request()->routeIs('Administration.SocialLinks.creer_lien_social')) {
    $titre = "Ajouter un lien sociale";
} else {
    $titre = "Modification d'un lien sociale";
}
@endphp
@section('titre', $titre)

@section('pagetitle')
<div class="pagetitle">
    <h1>Lien sociale</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Lien social</li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.SocialLinks.social_link')}}">Liste</a>
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
    <div class="alert alert-success text-center">
        {{session('succes')}}
    </div>
    @endif
    @if (session('erreur'))
    <div class="alert alert-erreur text-center">
        {{session('erreur')}}
    </div>
    @endif
    @if (request()->routeIs('Administration.SocialLinks.creer_lien_social'))
        <form action="" method="post">
            @csrf
            <label for="type">Ajouter le type:</label>
            <input type="text" name="type" id="type" class="form-control" value="{{@old('type')}}">
            @error('type')
                <p style="color: rgb(170, 16, 16)">
                    {{$message}}
                </p>
            @enderror
            {{-- lien --}}
            <label for="lien">Ajouter le lien:</label>
            <input type="text" name="lien" id="lien" class="form-control" value="{{@old('lien')}}">
            @error('lien')
                <p style="color: rgb(170, 16, 16)">
                    {{$message}}
                </p>
            @enderror
            <input type="submit" value="Ajouter" class="btn btn-primary" style="margin-top: 15px; width:100%">
        </form>
    @else
        <form action="" method="post">
            @csrf
            @method('PUT')
            <label for="type">Modifier le type:</label>
            <input type="text" name="type" id="type" class="form-control" value="{{$social->type}}">
            @error('type')
                <p style="color: rgb(170, 16, 16)">
                    {{$message}}
                </p>
            @enderror
            {{-- lien --}}
            <label for="lien">Modifier le type:</label>
            <input type="text" name="lien" id="lien" class="form-control" value="{{$social->lien}}">
            @error('lien')
                <p style="color: rgb(170, 16, 16)">
                    {{$message}}
                </p>
            @enderror
            <input type="submit" value="Modifier" class="btn btn-primary" style="margin-top: 15px; width:100%">
        </form>
    @endif
@endsection

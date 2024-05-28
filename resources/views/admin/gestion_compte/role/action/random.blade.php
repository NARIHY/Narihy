@extends('admin')
@php
$titre = "";
if(request()->routeIs('Administration.SocialLinks.creer_lien_social')) {
    $titre = "Ajouter un nouveau role";
} else {
    $titre = "Modification d'un role";
}
@endphp

@section('titre', $titre)

@section('pagetitle')
<div class="pagetitle">
    <h1>Gestion de compte</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestion de compte</li>
        <li class="breadcrumb-item"><a href="{{route('Administration.GestionCompte.Role.liste_role')}}">Role</a></li>
        <li class="breadcrumb-item active">Création</li>
      </ol>
    </nav>
  </div>
@endsection

@section('contenu')
    @if (session('succes'))
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
    @if (request()->routeIs('Administration.GestionCompte.Role.creer_role'))
        <form action="" method="post">
            @csrf
            <label for="status">Ajouter le status:</label>
            <input type="text" name="status" id="status" class="form-control" value="{{@old('status')}}">
            @error('status')
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
            <label for="status">Modifier le status:</label>
            <input type="text" name="status" id="status" class="form-control" value="{{$role->status}}">
            @error('status')
                <p style="color: rgb(170, 16, 16)">
                    {{$message}}
                </p>
            @enderror
            <input type="submit" value="Modifier" class="btn btn-primary" style="margin-top: 15px; width:100%">
        </form>
    @endif
@endsection

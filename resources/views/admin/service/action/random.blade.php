@extends('admin')

@php
$titre = "";
if(request()->routeIs('Administration.Service.creer_service')) {
    $titre = "Ajout d'un nouveau service";
} else {
    $titre = "Edition d'un service";
}
@endphp

@section('titre', $titre)

@section('pagetitle')
<div class="pagetitle">
    <h1>Mes services</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Service</li>
        <li class="breadcrumb-item"><a href="{{route('Administration.Service.liste_service')}}">Acceuil</a></li>
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
@if (request()->routeIs('Administration.Service.creer_service'))
    <div class="card">
        <div class="card-title">
            <h2 class="text-center">
                {{$titre}}
            </h2>
        </div>
        <div class="card-body">
            <form action="" method="post">
                @csrf
                <label for="nomService">Nom du service</label>
                <input type="text" name="nomService" id="nomService" class="form-control" value="{{@old('nomService')}}">
                @error('nomService')
                    <p style="color: red">
                        {{$message}}
                    </p>
                @enderror
                {{-- Separation --}}

                <label for="description">Description du service</label>
                <input type="text" name="description" id="description" class="form-control" value="{{@old('description')}}">
                @error('description')
                    <p style="color: red">
                        {{$message}}
                    </p>
                @enderror

                {{-- separation --}}

                <label for="icons">Bootstrap icons (Format bi *)</label>
                <input type="text" name="icons" id="icons" class="form-control" value="{{@old('icons')}}">
                @error('icons')
                    <p style="color: red">
                        {{$message}}
                    </p>
                @enderror
                <input type="submit" value="Sauvgarder" class="btn btn-primary" style="width:100%; margin-top:15px">
            </form>
        </div>
  </div>
@else
    <div class="card-title">
        <h2 class="text-center">
            {{$titre}}
        </h2>
    </div>
    <div class="card-body">
        <form action="" method="post">
            @csrf
            @method('PUT')
            <label for="nomService">Nom du service</label>
            <input type="text" name="nomService" id="nomService" class="form-control" value="{{$service->nomService}}">
            @error('nomService')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror
            {{-- Separation --}}

            <label for="description">Description du service</label>
            <input type="text" name="description" id="description" class="form-control" value="{{$service->description}}">
            @error('description')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror

            {{-- separation --}}

            <label for="icons">Bootstrap icons (Format bi *)</label>
            <input type="text" name="icons" id="icons" class="form-control" value="{{$service->icons}}">
            @error('icons')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror
            <input type="submit" value="Editer" class="btn btn-primary" style="width:100%; margin-top:15px">
        </form>
    </div>
@endif

@endsection

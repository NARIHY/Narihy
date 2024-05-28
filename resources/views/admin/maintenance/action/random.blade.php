@extends('admin')
@php
$titre = "";
if(request()->routeIs('Administration.SiteMaintenance.creation')){
    $titre = "creation d\'une maintenance";
} else {
    $titre = "modification d\'une maintenance";
}

@endphp
@section('titre', $titre)

@section('pagetitle')
<div class="pagetitle">
    <h1>Maintenance</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Maintenance</li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.SiteMaintenance.liste')}}">Liste</a>
        </li>
        <li class="breadcrumb-item active">{{$titre}}</li>
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


@if(request()->routeIs('Administration.SiteMaintenance.creation'))

<form action="" method="post">
    @csrf
    <label for="">Date de la maintenance</label>
    <input type="date" name=""class="form-control" id="">
    @error('')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    <input type="submit" value="Valider" class="btn btn-primary">
</form>

@else
<form action="" method="post">
    @csrf
    @method('PUT')
    <label for="">Date de la maintenance</label>
    <input type="date" name=""class="form-control" id="" value="">
    @error('')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    <input type="submit" value="Valider" class="btn btn-primary">
</form>

@endif
@endsection

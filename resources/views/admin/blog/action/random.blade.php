@extends('admin')

@php
$titre = "";
if(request()->routeIs('Administration.Blog.creer_une_blog')) {
    $titre = "Creation d'une blog";
} else {
    $titre = "Modification d'une blog";
}
@endphp
@section('titre', $titre)

@section('pagetitle')
<div class="pagetitle">
    <h1>Blog</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Blog</li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.Blog.liste_les_blogs')}}">Liste</a>
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

@if(request()->routeIs('Administration.Blog.creer_une_blog'))

<form action="" method="post" enctype="multipart/form-data">
    @csrf
    {{-- titre --}}
    <label for="titre">Titre du blog</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{@old('titre')}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- contenu --}}
    <label for="contenu">Contenu du blog</label>
    <textarea name="contenu" id="contenu" class="form-control" cols="30" rows="10">
        {{@old('contenu')}}
    </textarea>
    @error('contenu')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- media --}}
    <label for="media">Media du blog</label>
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
    <label for="titre">Titre du blog</label>
    <input type="text" name="titre" id="titre" class="form-control" value="{{$blog->titre}}">
    @error('titre')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- contenu --}}
    <label for="contenu">Contenu du blog</label>
    <textarea name="contenu" id="contenu" class="form-control" cols="30" rows="10">
        {{$blog->contenu}}
    </textarea>
    @error('contenu')
        <p style="color: red">
            {{$message}}
        </p>
    @enderror

    {{-- media --}}
    <div class="row mb-3">
        <div class="col md-6">
            <label for="media">Media du blog</label>
            <input type="file" name="media" id="media" class="form-control">
            @error('media')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror
        </div>
        <div class="col md-6">
            <img src="/storage/{{$blog->media}}" alt="{{$blog->titre}}" style="width: 100%;margin-top:15px">
        </div>
    </div>

    <input type="submit" value="Enregistrer" class="btn btn-primary" style="width: 75%; margin-top:15px">
</form>

@endif


@endsection

@extends('admin')

@section('titre', $contact->sujet_conversation)

@section('pagetitle')
<div class="pagetitle">
    <h1>Contacte</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Contacte</li>
        <li class="breadcrumb-item">
            <a href="{{route('Administration.Contacte.liste_contacte')}}">Liste des messages reçu</a>
        </li>
        <li class="breadcrumb-item active">Répondre à {{$contact->nom}} {{$contact->prenon}}</li>
      </ol>
    </nav>
  </div>
@endsection

@section('contenu')
  <div class="container">
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
        <form action="" method="post">
            @csrf
            <label for="intro">Introduction à la lettre:</label>
            <textarea name="intro" id="intro" class="form-control" cols="30" rows="10">
                {{@old('intro')}}
            </textarea>
            @error('intro')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror

            <label for="content">Contenu de la lettre:</label>
            <textarea name="content" id="content" class="form-control" cols="30" rows="10">
                {{@old('content')}}
            </textarea>
            @error('content')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror

            <label for="ending">Conclusion de la lettre:</label>
            <textarea name="ending" id="ending" class="form-control" cols="30" rows="10">
                {{@old('ending')}}
            </textarea>
            @error('ending')
                <p style="color: red">
                    {{$message}}
                </p>
            @enderror

            <input type="submit" value="Envoyer" style="margin-top: 15px; width:100%" class="btn btn-outline-primary">
        </form>
  </div>
@endsection

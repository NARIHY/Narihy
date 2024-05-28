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
        <li class="breadcrumb-item active">message de {{$contact->nom}} {{$contact->prenon}}</li>
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
  <div class="container">
        <h2 class="text-center">
            {{$contact->sujet_conversation}}
        </h2>
        <div class="row mb-3">
            <div class="col md-6">
                <h4>
                 {{strtoupper($contact->nom)}} {{ucfirst(strtolower($contact->prenon))}}
                </h4>
            </div>
            <div class="col md-6">
                <h4>
                    {{$contact->email}}
                </h4>
            </div>
        </div>

        <p style="text-align: justify">
            {{$contact->message}}
        </p>

        @if ($contact->reponse === 0)
            <div class="text-center">
                <a href="{{route('Administration.Contacte.answer_users', ['contactId' => $contact->id])}}" class="btn btn-dark"> répondre <i class="bi bi-arrow-90deg-right"></i> </a>
            </div>
        @endif
  </div>
@endsection

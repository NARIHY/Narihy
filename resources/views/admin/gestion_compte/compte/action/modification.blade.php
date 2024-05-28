@extends('admin')

@section('titre', 'Liste des comptes')

@section('pagetitle')
<div class="pagetitle">
    <h1>Gestion de compte</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestion de compte</li>
        <li class="breadcrumb-item"><a href="{{route('Administration.GestionCompte.Compte.liste_compte')}}">Liste des compte</a></li>
        <li class="breadcrumb-item active">Modification d'accès</li>
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
        <div class="card">
            <div class="card-title">
                <h3 class="text-center">
                    Information sur l'utilisateur
                </h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col md-6">
                        <h4>
                            {{$utilisateur->nom}} {{$utilisateur->prenon}}
                        </h4>
                        <h4>
                            {{$utilisateur->username}}
                        </h4>
                        <h4>
                            {{$utilisateur->email}}
                        </h4>
                        <h4>
                            Accès: {{$utilisateur->role->status}}
                        </h4>


                    </div>
                    <div class="col md-6 text-center">
                        @if(!empty($utilisateur->photo))
                            <img src="/storage/{{$utilisateur->photo}}" alt="{{$utilisateur->photo}}" class="rounded-circle" width="150px" height="150px">
                        @else
                            <img src="{{asset('users-default/default.png')}}" alt="{{$utilisateur->photo}}" class="rounded-circle" width="150px" height="150px">
                        @endif
                    </div>
                </div>
                <form action="" method="post">
                    @csrf
                    @method('PUT')
                    <label for="role_id">
                        Accès de l'utilisateur
                    </label>
                    <select name="role_id" id="role_id" class="form-control">
                        <option value="">Selectionner un rôle</option>
                        @foreach ($role as $k => $v)
                            <option value="{{$v}}" @if($v === $utilisateur->role_id) selected @endif>
                            {{$k}}
                            </option>
                        @endforeach
                    </select>
                    <input type="submit" value="Sauvgarder" class="btn btn-primary" style="width:100%; margin-top:15px">
                </form>
            </div>
        </div>

@endsection

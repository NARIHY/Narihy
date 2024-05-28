@extends('admin')

@section('titre', 'Mon profile')

@section('pagetitle')
<div class="pagetitle">
    <h1>Mon profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Mon profile</li>
        <li class="breadcrumb-item active"><a href="">Acceuil</a></li>
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

{{-- Begin to code here --}}

<div class="card" style="padding: 20px">
    <div class="row mb-3">
        <div class="col md-6">
            <img src="/storage/{{$utilisateur->photo}}" alt="{{$utilisateur->nom}}">
        </div>
        <div class="col md-6 text-center">
            <h3>
                {{ucfirst(strtolower($utilisateur->prenon))}} {{strtoupper($utilisateur->nom)}}
            </h3>
            <h4>
                {{strtoupper($utilisateur->username)}} <b style="font-size: 10px"> ({{$utilisateur->role->status}})</b>
            </h4>
            @php
                $date = new \Core\Date\DateFormaterFr($utilisateur->created_at);
                $date1 = new \Core\Date\DateFormaterFr($utilisateur->updated_at);
            @endphp
            <h4>
                Date de création: <b style="text-decoration: underline; color:green">
                {{$date->formatage_simple_fr()}}
                </b>
            </h4>
            <h4>
                Date de modification: <b style="text-decoration: underline; color:blue">
                    {{$date1->formatage_simple_fr()}}
                    </b>
            </h4>
        </div>
    </div>
    <div class="card-body pb-0">
        <h5 class="card-title">Publication <span>| Récemment créer</span></h5>

        <table class="table table-borderless">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">titre</th>
              <th scope="col">Dans</th>
              <th scope="col">publier par</th>
            </tr>
          </thead>
          <tbody>
              @foreach ($blogs as $blog)
                  <tr>
                      <th scope="row">
                            {{$blog->id}}
                      </th>
                      <td><a href="#" class="text-primary fw-bold">{{$blog->titre}}</a></td>
                      <td>Blog</td>
                      <td>Vous</td>
                  </tr>
              @endforeach
              @foreach ($portfolio as $p)
                  <tr>
                      <th scope="row">
                            {{$p->id}}
                      </th>
                      <td><a href="#" class="text-primary fw-bold">{{$p->titre}}</a></td>
                      <td>Portfolio</td>
                      <td>Vous</td>
                  </tr>
              @endforeach

          </tbody>
        </table>

      </div>
</div>
@endsection

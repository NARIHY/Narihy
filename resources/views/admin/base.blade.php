@extends('admin')

@section('titre', 'Tableau de bord')

@section('pagetitle')
<div class="pagetitle">
    <h1>Tableau de bord</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Tableau de bord</li>
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
@endif
@if (session('warning'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    {{session('warning')}}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
{{-- Begin here --}}
<div class="container">
    <div class="row mb-3">
        <div class="col md-4">
            <div class="card text-center">
                <div class="card-title">
                    <h4>
                        Actualité
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col md-6">
                            <h4>
                                Nbr totale
                            </h4>
                            <h4>
                                Publié
                            </h4>
                        </div>
                        <div class="col md-6">
                            <h4 style="color: blue">
                                {{$actualite_count}}
                             </h4>
                             <h4 style="color: green">
                                 {{$actualite_count_publier}}
                             </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col md-4">
            <div class="card text-center">
                <div class="card-title">
                    <h4>
                        Blogs
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col md-6">
                            <h4>
                                Nbr totale
                            </h4>
                            <h4>
                                Publié
                            </h4>
                        </div>
                        <div class="col md-6">
                            <h4 style="color: blue">
                                {{$blog_count}}
                             </h4>
                             <h4 style="color: green">
                                 {{$blog_count_publier}}
                             </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col md-4">
            <div class="card text-center">
                <div class="card-title">
                    <h4>
                        Contacte
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col md-6">
                            <h4>
                                Nbr totale
                            </h4>
                            <h4>
                                Répondu
                            </h4>
                        </div>
                        <div class="col md-6">
                            <h4 style="color: blue">
                                {{$contact_count}}
                             </h4>
                             <h4 style="color: green">
                                 {{$contact_count_repondu}}
                             </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Ending --}}
    <div class="row mb-3">
        <div class="col md-4">
            <div class="card text-center">
                <div class="card-title">
                    <h4>
                        Portfolio
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col md-6">
                            <h4>
                                Nbr totale
                            </h4>
                            <h4>
                                Publié
                            </h4>
                        </div>
                        <div class="col md-6">
                            <h4 style="color: blue">
                                {{$portfolio_count}}
                             </h4>
                             <h4 style="color: green">
                                 {{$portfolio_count_publier}}
                             </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col md-4">
            <div class="card text-center">
                <div class="card-title">
                    <h4>
                        Publicité
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col md-6">
                            <h4>
                                Nbr totale
                            </h4>
                            <h4>
                                Envoyé
                            </h4>
                        </div>
                        <div class="col md-6">
                            <h4 style="color: blue">
                                {{$publiciter_count}}
                             </h4>
                             <h4 style="color: green">
                                 {{$publiciter_count_envoyer}}
                             </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col md-4">
            <div class="card text-center">
                <div class="card-title">
                    <h4>
                        Service
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col md-6">
                            <h4>
                                Nbr totale
                            </h4>
                            <h4>
                                Publié
                            </h4>
                        </div>
                        <div class="col md-6">
                            <h4 style="color: blue">
                                {{$service_count}}
                             </h4>
                             <h4 style="color: green">
                                 {{$service_count_publier}}
                             </h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- List all blogs --}}
<div class="card top-selling overflow-auto">

    {{-- <div class="filter">
      <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        <li class="dropdown-header text-start">
          <h6>Filter</h6>
        </li>

        <li><a class="dropdown-item" href="#">Today</a></li>
        <li><a class="dropdown-item" href="#">This Month</a></li>
        <li><a class="dropdown-item" href="#">This Year</a></li>
      </ul>
    </div> --}}

    <div class="card-body pb-0">
      <h5 class="card-title">Blog <span>| Récemment créer</span></h5>

      <table class="table table-borderless">
        <thead>
          <tr>
            <th scope="col">media</th>
            <th scope="col">titre</th>
            <th scope="col">publier par</th>
            <th scope="col">status</th>
          </tr>
        </thead>
        <tbody>
            @forelse ($blogs as $blog)
                <tr>
                    <th scope="row"><a href="/storage/{{$blog->media}}"><img src="/storage/{{$blog->media}}" alt="{{$blog->titre}}"></a></th>
                    <td><a href="#" class="text-primary fw-bold">{{$blog->titre}}</a></td>
                    <td>{{$blog->users->username}}</td>
                    @php
                        $status = "";
                        if($blog->status === 1) {
                            $status = "active";
                        } else {
                            $status = "inactive";
                        }
                    @endphp
                    <td class="fw-bold">
                        <p  @if($blog->status === 1) class="badge bg-success" @else class="badge bg-danger" @endif>
                            {{$status}}
                        </p>
                    </td>
                </tr>
            @empty
                <tr>
                    <th scope="row"></th>
                    <td><a href="#" class="text-primary fw-bold"></a></td>
                    <td> Aucune blog n'est publié</td>
                    <td class="fw-bold"></td>
                </tr>
            @endforelse

        </tbody>
      </table>

    </div>

  </div>
@endsection

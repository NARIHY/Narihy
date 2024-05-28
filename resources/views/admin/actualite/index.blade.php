@extends('admin')

@section('titre', 'Liste des actualité')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.Actualite.creer_actualite')}}" style="float: right" class="btn btn-success">
        Creer un actu
    </a>
    <h1>
        Actualité
    </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Actualité
        </li>
        <li class="breadcrumb-item active">
            Liste
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

<table class="table table-dark table-borderless">
    <thead>
    <tr>
        <th scope="col" style="color: yellow">#</th>
        <th scope="col" style="color: yellow">titre</th>
        <th scope="col" style="color: yellow">Description</th>
        <th scope="col" style="color: yellow">status</th>
        <th scope="col" style="color: yellow"> action</th>
    </tr>
    </thead>

    <tbody>
        @forelse ($actualites as $actu)
            <tr>
                <th scope="row" style="color: yellow">
                    {{$actu->id}}
                </th>

                <td>
                    {{$actu->titre}}
                </td>
                <td>
                    {{$actu->description}}
                </td>
                <td>
                    <form action="{{route('Administration.Actualite.changer_status_actu', ['actualiteId' => $actu->id])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="submit" @if($actu->status === 1) value="actif" style="color:green;background-color:transparent;border:transparent;" @else value="inactif" style="color:red;background-color:transparent;border:transparent;" @endif>
                    </form>
                </td>
                <td>
                    <div class="row mb-3">

                        <div class="col md-6">
                            <a href="{{route('Administration.Actualite.edition_actualite', ['actualiteId' => $actu->id])}}" class="btn btn-primary">Modifier</a>
                        </div>
                        <div class="col md-6">
                            <form action="{{route('Administration.Actualite.supression_simple_actu', ['actualiteId' => $actu->id])}}" method="post">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Suprimer" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <th scope="row"></th>
                <td style="text-align: center">Aucune actualité pour le moment</td>
                <td>

                </td>
                <td>

                </td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
    </table>

    {{$actualites->links()}}
@endsection

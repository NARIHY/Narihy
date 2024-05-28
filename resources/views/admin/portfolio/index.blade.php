@extends('admin')

@section('titre', 'Catégorie de portfolio')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.Portfolio.MesPortfolio.ajouter_portfolio')}}" style="float: right" class="btn btn-success">
        Créer
    </a>
    <h1>
        Portfolio
    </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Potfolio
        </li>
        <li class="breadcrumb-item active"><a href="">Liste</a></li>
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
        <th scope="col" style="color: yellow">Status</th>
        <th scope="col" style="color: yellow">Action</th>
    </tr>
    </thead>

    <tbody>
        @forelse ($portfolio as $p)
            <tr>
                <th scope="row" style="color: yellow">
                    {{$p->id}}
                </th>

                <td>
                    {{$p->titre}}
                </td>
                <td>
                    {{$p->description}}
                </td>

                <td>
                    <form action="{{route('Administration.Portfolio.MesPortfolio.changer_status', ['portfolioId' => $p->id])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="submit" @if($p->status === 1) value="actif" style="color:green;background-color:transparent;border:transparent;" @else value="inactif" style="color:red;background-color:transparent;border:transparent;" @endif>
                    </form>
                </td>
                <td>
                    <div class="row mb-3">
                        <div class="col md-6">
                            <a href="{{route('Administration.Portfolio.MesPortfolio.edition_portfolio', ['portfolioId' => $p->id])}}" class="btn btn-primary">Modifier</a>
                        </div>
                        <div class="col md-6">
                            <form action="{{route('Administration.Portfolio.MesPortfolio.suprimer_portfolio', ['portfolioId' => $p->id])}}" method="post">
                                @csrf
                                @method('DELETE')
                                <input type="submit" value="Suprimer" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <th scope="row"></th>
                <td></td>
                <td style="text-align: center">Aucune portfolio n'est inscrit dans l'application.</td>
                <td></td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
    </table>

    {{$portfolio->links()}}
@endsection

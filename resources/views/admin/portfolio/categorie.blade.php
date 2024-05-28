@extends('admin')

@section('titre', 'Catégorie de portfolio')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.Portfolio.Categorie.creer_categorie_portfolio')}}" style="float: right" class="btn btn-success">
        Créer
    </a>
    <h1>
        Portfolio
    </h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
            Catégorie de portfolio
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
        <th scope="col" style="color: yellow">Action</th>
    </tr>
    </thead>

    <tbody>
        @forelse ($category as $categ)
            <tr>
                <th scope="row" style="color: yellow">
                    {{$categ->id}}
                </th>

                <td>
                    {{$categ->titre}}
                </td>
                <td>
                    <div class="row mb-3">
                        <div class="col md-6">
                            <a href="{{route('Administration.Portfolio.Categorie.edition_categorie_portfolio', ['categPortfolioId' => $categ->id])}}" class="btn btn-primary">Modifier</a>
                        </div>
                        <div class="col md-6">
                            <form action="{{route('Administration.Portfolio.Categorie.suprimer_categorie_portfolio', ['categPortfolioId' => $categ->id])}}" method="post">
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
                <td style="text-align: center">Aucune categorie de portfolio pour le moment.</td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
    </table>
    {{$category->links()}}
@endsection

@extends('admin')

@section('titre', 'Lien sociale')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.SocialLinks.creer_lien_social')}}" class="btn btn-success" style="float: right">Ajouter</a>
    <h1>Lien sociale</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Lien social</li>
        <li class="breadcrumb-item active">Liste</li>
      </ol>
    </nav>
  </div>
@endsection

@section('contenu')
        @if (session('succes'))
            <div class="alert alert-success text-center">
                {{session('succes')}}
            </div>
        @endif
        @if (session('erreur'))
            <div class="alert alert-erreur text-center">
                {{session('erreur')}}
            </div>
        @endif

        <table class="table table-dark table-borderless">
            <thead>
              <tr>
                <th scope="col" style="color: yellow">#</th>
                <th scope="col" style="color: yellow">Type</th>
                <th scope="col" style="color: yellow">Action</th>
              </tr>
            </thead>

            <tbody>
                @forelse ($social as $s)
                    <tr>
                        <th scope="row" style="color: yellow">
                            {{$s->id}}
                        </th>

                        <td>
                            {{$s->type}}
                        </td>
                        <td>
                            <div class="row mb-3">
                                <!-- pour la modification -->
                                <div class="col md-6">
                                    <a href="{{route('Administration.SocialLinks.edition_social_link', ['id' => $s->id])}}" class="btn btn-primary">Modifier</a>
                                </div>
                                <!-- Pour la supréssion -->
                                <div class="col md-6">
                                    <form action="{{route('Administration.SocialLinks.suprimer_lien_sociale', ['id' => $s->id])}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <input type="submit" class="btn btn-danger" value="Suprimer">
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <th scope="row"></th>
                        <td style="text-align: center">Aucune utilisateurs n'est inscrit pour le moment</td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
          </table>
          {{$social->links()}}
@endsection

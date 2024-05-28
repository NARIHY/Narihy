@extends('admin')

@section('titre', 'Mes services')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.Service.creer_service')}}" style="float: right" class="btn btn-success">
        Ajouter
    </a>
    <h1>Mes services</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Service</li>
        <li class="breadcrumb-item active"><a href="">Acceuil</a></li>
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
        <th scope="col" style="color: yellow">nom du service</th>
        <th scope="col" style="color: yellow"> Status</th>
        <th scope="col" style="color: yellow">Action</th>
    </tr>
    </thead>

    <tbody>
        @forelse ($service as $s)
            <tr>
                <th scope="row" style="color: yellow">
                    {{$s->id}}
                </th>

                <td>
                    {{$s->nomService}}
                </td>
                <td>
                    <form action="{{route('Administration.Service.set_status', ['serviceId' => $s->id])}}" method="post">
                        @csrf
                        @method('PATCH')
                        @if ($s->status !== '0')
                            <input type="submit" value="Visible" style="background: transparent; border:none; color:green; font-size:18px">
                        @else
                            <input type="submit" value="Cacher" style="background: transparent; border:none; color:rgb(224, 17, 17); font-size:18px">
                        @endif
                    </form>
                </td>
                <td>
                    <div class="row mb-3">
                        <!-- pour la modification -->
                        <div class="col md-6">
                            <a href="{{route('Administration.Service.edition_service', ['serviceId' => $s->id])}}" class="btn btn-primary">Modifier</a>
                        </div>
                        <!-- Pour la supréssion -->
                        <div class="col md-6">
                            <form action="{{route('Administration.Service.supprimer_service', ['serviceId' => $s->id])}}" method="post">
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
                <td></td>
                <td style="text-align: center">Aucune service n'est inscrit pour le moment</td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
    </table>
@endsection

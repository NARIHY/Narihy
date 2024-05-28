@extends('admin')

@section('titre', 'Liste des rôle')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.GestionCompte.Role.creer_role')}}" class="btn btn-success" style="float: right">Créer</a>
    <h1>Gestion de compte</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestion de compte</li>
        <li class="breadcrumb-item active"><a href="">Liste des rôles</a></li>
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
                <th scope="col" style="color: yellow">Status</th>
                <th scope="col" style="color: yellow">Action</th>
              </tr>
            </thead>

            <tbody>
                @forelse ($roles as $role)
                    <tr>
                        <th scope="row" style="color: yellow">
                            {{$role->id}}
                        </th>

                        <td>
                            {{$role->status}}
                        </td>
                        <td>
                            <div class="row mb-3">
                                <!-- pour la modification -->
                                <div class="col md-6">
                                    <a href="{{route('Administration.GestionCompte.Role.modifier_role', ['id' => $role->id])}}" class="btn btn-primary">Modifier</a>
                                </div>
                                <!-- Pour la supréssion -->
                                <div class="col md-6">
                                    <form action="{{route('Administration.GestionCompte.Role.suprimer_role',['id' => $role->id])}}" method="post">
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
                        <td style="text-align: center">Aucune role n'est inscrit pour le moment</td>
                        <td></td>
                    </tr>
                @endforelse
            </tbody>
          </table>
@endsection

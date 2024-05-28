@extends('admin')

@section('titre', 'Publiciter ')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.Publiciter.creer_une_publiciter')}}" style="float: right" class="btn btn-success"> Créer une publicité</a>
    <h1>Publicité</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Publicité</li>
        <li class="breadcrumb-item active">
            <a href="">Liste</a>
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
    <th scope="col" style="color: yellow"> description </th>
    <th scope="col" style="color: yellow"> status </th>
    <th scope="col" style="color: yellow"> action</th>
</tr>
</thead>

<tbody>
    @forelse ($publicites as $pub)
        <tr>
            <th scope="row" style="color: yellow">
                {{$pub->id}}
            </th>

            <td>
                {{$pub->titre}}
            </td>
            <td>
                {{$pub->description_pub}}
            </td>
            <td @if ($pub->status === 1) style="background-color:green; "  @else style="background-color:red;"  @endif>

            </td>
            <td>
                @if ($pub->status !== 1)
                    <div class="row mb-3 text-center">
                        <div class="col md-3">
                            <form action="{{route('Administration.Publiciter.send_publicite', ['publiciteId' => $pub->id])}}" method="post">
                                @csrf
                                <input type="submit" value="Publier" class="btn btn-success">
                            </form>
                        </div>
                        <div class="col md-3">
                            <a href="{{route('Administration.Publiciter.modifier_une_pub', ['publiciteId' => $pub->id])}}" class="btn btn-primary">Modifier</a>
                        </div>
                        <div class="col md-3">
                            <form action="{{route('Administration.Publiciter.suppression_simple_pub', ['publiciteId' => $pub->id])}}" method="post">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Suprimer" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                @else
                    <div class="row mb-3 text-center">
                        <div class="col md-6">
                            <a href="{{route('Administration.Publiciter.modifier_une_pub', ['publiciteId' => $pub->id])}}" class="btn btn-primary">Modifier</a>
                        </div>
                        <div class="col md-6">
                            <form action="{{route('Administration.Publiciter.suppression_simple_pub', ['publiciteId' => $pub->id])}}" method="post">
                                @method('DELETE')
                                @csrf
                                <input type="submit" value="Suprimer" class="btn btn-danger">
                            </form>
                        </div>
                    </div>
                @endif
            </td>
        </tr>
    @empty
        <tr>
            <th scope="row"></th>
            <td style="text-align: center">Aucune publicité pour le moment</td>
            <td>

            </td>
            <td></td>
            <td></td>
        </tr>
    @endforelse
</tbody>
</table>

{{$publicites->links()}}
@endsection

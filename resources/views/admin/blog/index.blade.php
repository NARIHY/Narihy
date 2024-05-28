@extends('admin')

@section('titre', 'Liste des blogs')

@section('pagetitle')
<div class="pagetitle">
    <a href="{{route('Administration.Blog.creer_une_blog')}}" style="float: right" class="btn btn-success">
        Creer un blog
    </a>
    <h1>Blog</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Blog</li>
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
        <th scope="col" style="color: yellow">status</th>
        <th scope="col" style="color: yellow"> action</th>
    </tr>
    </thead>

    <tbody>
        @forelse ($blogs as $blog)
            <tr>
                <th scope="row" style="color: yellow">
                    {{$blog->id}}
                </th>

                <td>
                    {{$blog->titre}}
                </td>
                <td>
                    <form action="{{route('Administration.Blog.change_status', ['blogId' => $blog->id])}}" method="post">
                        @csrf
                        @method('PATCH')
                        <input type="submit" @if($blog->status === 1) value="actif" style="color:green;background-color:transparent;border:transparent;" @else value="inactif" style="color:red;background-color:transparent;border:transparent;" @endif>
                    </form>
                </td>
                <td>
                    <div class="row mb-3">

                        <div class="col md-6">
                            <a href="{{route('Administration.Blog.modifier_blog', ['blogId' => $blog->id])}}" class="btn btn-primary">Modifier</a>
                        </div>
                        <div class="col md-6">
                            <form action="{{route('Administration.Blog.supression_simple', ['blogId' => $blog->id])}}" method="post">
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
                <td style="text-align: center">Aucune blog pour le moment</td>
                <td>

                </td>
                <td></td>
            </tr>
        @endforelse
    </tbody>
    </table>

    {{$blogs->links()}}
@endsection

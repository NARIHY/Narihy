@extends('admin')

@section('titre', 'Contacte')

@section('pagetitle')
<div class="pagetitle">
    <h1>Contacte</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Contacte</li>
        <li class="breadcrumb-item active">Liste des messages reçu</li>
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
    <th scope="col" style="color: yellow">email</th>
    <th scope="col" style="color: yellow"> sujet de conversation</th>
    <th scope="col" style="color: yellow"> status</th>
    <th scope="col" style="color: yellow"> repondue</th>
    @if($user->id !== 2)
        <th scope="col" style="color: yellow"> repondue par</th>
    @endif
    <th scope="col" style="color: yellow">Action</th>
</tr>
</thead>

<tbody>
    @forelse ($contacts as $contact)
        <tr>
            <th scope="row" style="color: yellow">
                {{$contact->id}}
            </th>

            <td>
                {{$contact->email}}
            </td>
            <td>
                {{$contact->sujet_conversation}}
            </td>
            <td @if ($contact->status === 'lue') style="background-color:green;" @else style="background-color:red;" @endif>
            </td>
            <td @if ($contact->reponse === 0) style="background-color:red;" @else style="background-color:green;" @endif>

            </td>
            @if ($contact->reponse === 1)
                @php
                    $id = $contact->publie_par;
                    $u = \App\Models\User::findOrFail($id);
                @endphp
                @if($user->id !== 2)
                    <td>
                        {{$u->username}}
                    </td>
                @endif
            @else
            <td>
                Vide
            </td>
            @endif
            <td>
                <a href="{{route('Administration.Contacte.voir_contacte', ['contactId' => $contact->id])}}" class="btn btn-primary">Voir</a>
            </td>
        </tr>
    @empty
        <tr>
            <th scope="row"></th>
            <td></td>
            <td></td>
            <td style="text-align: center">Aucune lessage n'est reçu pour le moment.</td>
            <td></td>
            @if($user->id !== 2)
                <td>

                </td>
            @endif
            <td></td>
        </tr>
    @endforelse
</tbody>
</table>
{{$contacts->links()}}
@endsection

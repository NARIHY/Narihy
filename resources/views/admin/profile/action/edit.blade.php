@extends('admin')

@section('titre', 'Mon profile / Edition')

@section('pagetitle')
<div class="pagetitle">
    <h1>Mon profile</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">Mon profile</li>
        <li class="breadcrumb-item">Edition</li>
        <li class="breadcrumb-item active">
            Mon compte
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

{{-- Begin to code here --}}
@endsection

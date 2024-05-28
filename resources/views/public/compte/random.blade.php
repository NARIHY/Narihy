@extends('auth')
@php
$titre = '';
if(request()->routeIs('Public.Auth.creation_compte')){
    $titre = "S'inscrire";
} else {
    $titre = "Se connecter";
}
@endphp
@section('titre',$titre)
@section('contenu')
    <section class="auth_section">
        <div class="container position-relative d-flex flex-column align-items-center">
            <h2 class="titre">{{strtoupper($titre)}}</h2>
        </div>
    </section>
    @if (request()->routeIs('Public.Auth.creation_compte'))
        <div class="container">
            <div class="text-center">
                <div class="before-card">
                    <div class="cards">
                        <p>
                            Afin de mieux sécuriser votre inscription dans l'application, veuillez juste remplir les formulaires inscrit ci-dessous et je ferais le reste.
                            Pour information, je ne vous connait pas. Mais je suis un script qui s'ative automatiquement quand vous m'envoyez vos réponse aux formulaire ci-dessous.
                            Ne vous enfaite pas personne ne sait appart vous vos identifiant (C'est à dire: Nom d'utilisateur, mots de passe et addresse email).
                            Après votre inscription d'ici, un email qui contiendra votre login seras envoyer vers votre addresse email.
                            S'il vous plaît, veuillez ne pas répondre à l'addresse email.
                        </p>
                        <h3 class="inscription">Formulaire d'inscription</h3>
                        <div class="form">
                            <form action="{{route('Public.Auth.sauvgarde_compte')}}" method="post">
                                @csrf
                                <label for="nom">Entrer votre nom</label>
                                <input type="text" name="nom" id="nom" class="__input">
                                @error('nom')
                                    <p style="color: red">
                                        {{$message}}
                                    </p>
                                @enderror
                                <label for="prenon">Entrer votre prenon</label>
                                <input type="text" name="prenon" id="prenon" class="__input">
                                @error('prenon')
                                    <p style="color: red">
                                        {{$message}}
                                    </p>
                                @enderror
                                <label for="username">Entrer votre nom d'utilisateur</label>
                                <input type="text" name="username" id="username" class="__input">
                                @error('username')
                                    <p style="color: red">
                                        {{$message}}
                                    </p>
                                @enderror
                                <label for="email">Entrer votre addresse email</label>
                                <input type="email" name="email" id="email" class="__input">
                                @error('email')
                                    <p style="color: red">
                                        {{$message}}
                                    </p>
                                @enderror
                                <input type="submit" value="S'inscrire" class="__btn">
                                <p style="text-align: center; color: black">
                                    Avez vous déjàs un compte? <a href="{{route('Public.Auth.se_connecter')}}" style="text-decoration: none; color:blue">Se connecter</a>
                                </p>
                            </form>
                        </div>
                        <div style="margin-top: 20px">
                            @if(session('succes'))
                            <div class="alert alert-success">
                                {{session('succes')}}
                            </div>
                            @endif
                            @if(session('erreur'))
                                <div class="alert alert-danger">
                                    {{session('erreur')}}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @else
        <div class="container">
            <div class="text-center">
                <div class="before-card">
                    <div class="cards">
                        <p>
                            WELCOME BACK (creer un text)
                        </p>
                        <h3 class="inscription">Formulaire de connexion</h3>
                        <div class="form">
                            <form action="" method="post">
                                @csrf
                                <label for="email">Entrer votre addresse email</label>
                                <input type="email" name="email" id="email" class="__input">
                                @error('email')
                                    <p style="color: red">
                                        {{$message}}
                                    </p>
                                @enderror
                                <label for="password">Entrer votre mots de passe</label>
                                <input type="password" name="password" id="password" class="__input">
                                @error('password')
                                    <p style="color: red">
                                        {{$message}}
                                    </p>
                                @enderror
                                <input type="submit" value="Se connecter" class="__btn">
                                    <p class="text-center">
                                        <a href="{{route('Public.Auth.creation_compte')}}" class="__link ins">
                                            S'inscrire
                                        </a>
                                        <a href="{{route('password.request')}}" class="__link">
                                            Mots de passe oublé?
                                        </a>
                                    </p>
                            </form>
                        </div>
                        <div style="margin-top: 20px">
                            @if(session('succes'))
                            <div class="alert alert-success">
                                {{session('succes')}}
                            </div>
                            @endif
                            @if(session('erreur'))
                                <div class="alert alert-danger">
                                    {{session('erreur')}}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    @endif
@endsection

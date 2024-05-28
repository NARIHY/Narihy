@extends('base')

@section('titre', $portfolio->titre)

@php
    //Pour le référencement
@endphp
@section('description')

@endsection

@section('keywords')

@endsection


@section('contenu')
    <section class="contact_section">
        <div class="container position-relative d-flex flex-column align-items-center">
            <h2 class="titre">PORTFOLIO /</h2>
            <h2 class="titre" style="color: yellow"> {{$portfolio->titre}} </h2>
        </div>
    </section>

    <div class="container">
        <section>
            <h4>
                {{$portfolio->titre}}
            </h4>
            <p class="__portfolio__description">
                {{$portfolio->description}}
            </p>

            <h4>
                Descrption:
            </h4>
            <div class="row mb-3">
                <div class="col md-6">
                    <p>
                        {{$portfolio->description}}
                    </p>
                </div>
                <div class="col md-6">
                    <img src="/storage/{{$portfolio->media}}" alt="{{$portfolio->titre}}" width="500px">
                    <ul>
                        <li>
                            {{$portfolio->categoryPortfolio->titre}}
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        @auth
            {{-- Classe pour permettre a une utilisateur de commenter une portfolio --}}
            <section class="__comments">
                <div class="__user__comments">
                    <h4>
                        John Doe
                    </h4>
                    <p>
                        Date: 06/03/2024
                    </p>
                    <p>
                        Premier commentaire
                    </p>

                </div>
                {{-- A rendre instantané --}}
                <div class="__send__comments">
                    <form action="" method="post">
                        <input type="submit" value="Envoyer" class="btn btn-primary" style="float: right">
                        <input type="text" name="message" id="message" class="form-control" style="width: 90%">

                    </form>
                </div>
            </section>
        @endauth
        <section>
            carousselle du portfolio de la personne proprietaire de cette portfolio

        </section>
    </div>
@endsection

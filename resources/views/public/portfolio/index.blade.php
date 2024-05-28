@extends('base')

@section('titre', 'Portfolio')

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
            <h2 class="titre">PORTFOLIO</h2>
        </div>
    </section>
    @if ($portfolio_count > 0)
        <section style="padding: 10px">
            @foreach ($portfolio as $p)
                @php
                    $date = new \Core\Date\DateFormaterFr($p->created_at);
                @endphp
                <div class="cards">
                    <img src="/storage/{{$p->media}}" class="cards-img" alt="image">
                    <div class="card-body">
                        <h5 class="cards-title">
                            {{$p->titre}}
                        </h5>
                        <div class="row mb-3">
                            <div class="col md-4">
                                <i class="bi bi-person"></i> <a href="">{{$p->users->username}}</a>
                            </div>
                            <div class="col md-4">
                                <i class="bi bi-clock"></i> <a href="">{{$date->formatage_simple()}}</a>
                            </div>
                            <div class="col md-4">
                                <i class="bi bi-chat-dots"></i> <a href="">12 Comments</a>
                            </div>
                        </div>

                        <p class="cards-body">
                            {{$p->description}}
                        </p>
                        <a href="{{route('Public.Portfolio.voir_portfolio', ['portfolioId' => $p->id])}}" style="float: right" class="btn btn-primary">Voir</a>
                    </div>
                </div>
            @endforeach
        </section>
    @endif
@endsection

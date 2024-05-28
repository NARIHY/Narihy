@extends('base')

@section('titre', 'Acceuil')

@php
    //Pour le référencement
@endphp
@section('description')

@endsection

@section('keywords')

@endsection


@section('contenu')
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">
        <div class="container">
        <div class="row">
            <div class="col-xl-4">
                <h2 data-aos="fade-up">
                    En route vers l'avenir
                </h2>
                <blockquote data-aos="fade-up" data-aos-delay="100">
                    <p>
                        C'est le chemin que nous traçons main dans la main, pour un futur riche de promesses. Un voyage où chaque défis est une opportunié, où chaque obstacle est surmonté par la persévérance et l'espoir.
                    </p>
                </blockquote>
                <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                    <a href="{{route('Public.Portfolio.acceuil')}}" class="btn-get-started">Commencer</a>
                    {{-- <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Watch Video</span></a> --}}
                </div>

            </div>
        </div>
        </div>
    </section><!-- End Hero Section -->

    <!-- ======= Our Services Section ======= -->
<section id="services-list" class="services-list">
    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>Mes services</h2>

      </div>

      <div class="row gy-5">
        @foreach ($service as $s)
            <div class="col-lg-4 col-md-6 service-item d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="icon flex-shrink-0">
                    <?= $s->icons ?>
                </div>
                <div>
                <h4 class="title"><a href="#" class="stretched-link">{{$s->nomService}}</a></h4>
                <p class="description">
                    {{$s->description}}
                </p>
                </div>
            </div>
        @endforeach
      </div>

    </div>
  </section><!-- End Our Services Section -->



    <!-- ======= Recent Blog Posts Section ======= -->
  <section id="recent-posts" class="recent-posts">
    <div class="container" data-aos="fade-up">

      <div class="section-header">
        <h2>Portfolio</h2>

      </div>

      <div class="row gy-5">
        @forelse ($portfolio as $p)
            <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="post-box">
                <div class="post-img"><img src="/storage/{{$p->media}}" class="img-fluid" alt="{{$p->titre}}"></div>

                @php
                    $date = new \Core\Date\DateFormaterFr($p->created_at);
                @endphp
                <div class="meta">
                    <span class="post-date">
                        {{$date->formatage_simple_fr()}}
                    </span>
                    <span class="post-author"> / {{$p->users->username}}</span>
                </div>

                <h3 class="post-title">{{$p->titre}}</h3>
                <p>
                    {{$p->description}}
                </p>
                <a href="{{route('Public.Portfolio.voir_portfolio', ['portfolioId' => $p->id])}}" class="__links"><span>Voir plus</span><i class="bi bi-arrow-right"></i></a>
                </div>
            </div>
        @empty
        <div class="text-center">
            <h3>
                Aucune portfolio n'est encore inscrit pour le moment
            </h3>
        </div>
        @endforelse



        {{-- <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="post-box">
            <div class="post-img"><img src="{{asset('public/assets/img/blog/blog-2.jpg')}}" class="img-fluid" alt=""></div>
            <div class="meta">
              <span class="post-date">Fri, September 05</span>
              <span class="post-author"> / Mario Douglas</span>
            </div>
            <h3 class="post-title">Et repellendus molestiae qui est sed omnis</h3>
            <p>Voluptatem nesciunt omnis libero autem tempora enim ut ipsam id. Odit quia ab eum assumenda. Quisquam omnis doloribus...</p>
            <a href="#" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

        <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="post-box">
            <div class="post-img"><img src="{{asset('public/assets/img/blog/blog-3.jpg')}}" class="img-fluid" alt=""></div>
            <div class="meta">
              <span class="post-date">Tue, July 27</span>
              <span class="post-author"> / Lisa Hunter</span>
            </div>
            <h3 class="post-title">Quia assumenda est et veritati</h3>
            <p>Quia nam eaque omnis explicabo similique eum quaerat similique laboriosam. Quis omnis repellat sed quae consectetur magnam...</p>
            <a href="#" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
          </div>
        </div>

        <div class="col-xl-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="post-box">
            <div class="post-img"><img src="{{asset('public/assets/img/blog/blog-4.jpg')}}" class="img-fluid" alt=""></div>
            <div class="meta">
              <span class="post-date">Tue, Sep 16</span>
              <span class="post-author"> / Mario Douglas</span>
            </div>
            <h3 class="post-title">Pariatur quia facilis similique deleniti</h3>
            <p>Et consequatur eveniet nam voluptas commodi cumque ea est ex. Aut quis omnis sint ipsum earum quia eligendi...</p>
            <a href="#" class="readmore stretched-link"><span>Read More</span><i class="bi bi-arrow-right"></i></a>
          </div>
        </div> --}}

      </div>
      <div class="text-center">
        <a href="{{route('Public.Portfolio.acceuil')}}" class="link" style="text-align: center">Voir plus</a>
      </div>
    </div>
  </section><!-- End Recent Blog Posts Section -->
@endsection



@extends('base')

@section('titre', 'Contact')

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
            <h2 class="titre">ME CONTACTER</h2>
        </div>
    </section>
    <section id="contact" class="contact">
        <div class="container position-relative aos-init aos-animate" data-aos="fade-up">

          <div class="row gy-4 d-flex justify-content-end">

            <div class="col-lg-5 aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">

              <div class="info-item d-flex">
                <i class="bi bi-geo-alt flex-shrink-0"></i>
                <div>
                  <h4>Localisation:</h4>
                  <p>ANTANANARIVO,MADAGASCAR</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-envelope flex-shrink-0"></i>
                <div>
                  <h4>Addresse E-mail:</h4>
                  <p>narihy@gmail.mg</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="bi bi-phone flex-shrink-0"></i>
                <div>
                  <h4>Téléphone:</h4>
                  <p>+261 34 12 751 02</p>
                </div>
              </div><!-- End Info Item -->

            </div>

            <div class="col-lg-6 aos-init aos-animate" data-aos="fade-up" data-aos-delay="250">

              <form action="" method="post" class="php-email-form">
                @csrf
                <div class="row">
                  <div class="col-md-6 form-group">
                    <input type="text" name="nom" class="form-control" id="nom" placeholder="Votre nom" required="">
                  </div>
                  <div class="col-md-6 form-group mt-3 mt-md-0">
                    <input type="text" class="form-control" name="prenon" id="prenon" placeholder="Votre prénon" required="">
                  </div>
                </div>
                <div class="form-group mt-3">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Votre addresse email" required="">
                </div>
                <div class="form-group mt-3">
                  <input type="text" class="form-control" name="sujet_conversation" id="sujet_conversation" placeholder="Votre sujet de conversation" required="">
                </div>
                <div class="form-group mt-3">
                  <textarea class="form-control" name="message" rows="5" placeholder="Message" required=""></textarea>
                </div>
                <div class="my-3">
                    @if (session('succes'))
                        <p style="color: green">
                            {{session('succes')}}
                        </p>
                    @endif
                    @if (session('erreur'))
                        <p style="color: rgb(255, 0, 0)">
                            {{session('erreur')}}
                        </p>
                    @endif
                </div>
                <div class="text-center"><button type="submit">Nous contacter</button></div>
              </form>

            </div><!-- End Contact Form -->

          </div>

        </div>
      </section>
@endsection

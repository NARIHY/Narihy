<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Maintenance</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('admin/assets/img/favicon.png')}}" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('maintenance/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('maintenance/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('maintenance/assets/css/style.css')}}" rel="stylesheet">


</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex flex-column align-items-center">

      <h1>MAINTENANCE</h1>
        <h2>
            {{-- We're working hard to improve our website and we'll ready to launch after --}}
            Nous travaillons dur pour améliorer notre site web le plus rapidement et le relancera plus tard.
        </h2>
      <div class="countdown d-flex justify-content-center" data-count="2024/06/26">
        <div>
          <h3>%d</h3>
          <h4>Jours</h4>
        </div>
        <div>
          <h3>%h</h3>
          <h4>Heure</h4>
        </div>
        <div>
          <h3>%m</h3>
          <h4>Minutes</h4>
        </div>
        <div>
          <h3>%s</h3>
          <h4>Secondes</h4>
        </div>
      </div>

      {{-- <div class="subscribe">
        <h4>Subscribe now to get the latest updates!</h4>
        <form action="forms/notify.php" method="post" role="form" class="php-email-form">
          <div class="subscribe-form">
            <input type="email" name="email"><input type="submit" value="Subscribe">
          </div>
          <div class="mt-2">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your notification request was sent. Thank you!</div>
          </div>
        </form>
      </div> --}}

        @php
            $facebook = \App\Models\SocialLink::where('type','facebook')->get('lien');
            $twitter = \App\Models\SocialLink::where('type','twitter')->get('lien');
            $instagram = \App\Models\SocialLink::where('type','instagram')->get('lien');
            $linkdin = \App\Models\SocialLink::where('type','linkdin')->get('lien');
        @endphp
      <div class="social-links text-center" style="font-size: 20px">
                @foreach ($twitter as $item)
                    <a href="{{$item->lien}}" target="blank" class="twitter"><i class="bi bi-twitter"></i></a>
                @endforeach
                @foreach ($facebook as $i)
                    <a href="{{$i->lien}}" class="facebook" target="blank"><i class="bi bi-facebook"></i></a>
                @endforeach
                @foreach ($instagram as $i)
                    <a href="{{$i->lien}}" target="blank" class="instagram"><i class="bi bi-instagram"></i></a>
                @endforeach
                @foreach ($instagram as $i)
                    <a href="{{$i->lien}}" target="blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
                @endforeach
      </div>

    </div>
  </header><!-- End #header -->

  <main id="main">

    <!-- ======= About Us Section ======= -->
    <section id="about" class="about">
      <div class="container">

        <div class="row content">
          <div class="col-lg-6">
            <h2>
                AVOIR UN SITE WEB PERFORMANT
            </h2>
            <h3>
                POURQUOI FAIRE UNE MAINTENANCE?
            </h3>
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0">
            <p>
              Faire une maintenance est un processus qui vise à garantir un bon fonctionnement d'une application, d'améliorer sa sécurité,
              et son éfficacité. Tout comme une voiture a besoin d'un entretien régulier pour rouler en toute sécurité. C'est à dire que faire une maintenance permet
              à votre application web de fonctionner de manière optiomale. Faire la maintenance présente de nombreuse avantage comme:
            </p>
            <ul>
                <li><i class="bi bi-check"></i>
                    Amélioration de l'expérience utilisateur
                </li>
                <li><i class="bi bi-check"></i>
                    Meilleur référencement naturel (SEO)
                </li>
                <li><i class="bi bi-check"></i>
                    Sécurité renforcer
                </li>
                <li><i class="bi bi-check"></i>
                    Correction des bugs
                </li>
                <li><i class="bi bi-check"></i>
                    Et divers autre avantages....
                </li>
            </ul>
            <p class="fst-italic">
                La maintenance d'une application web est un processus continu essentiel pour son bon fonctionnement, sa sécurité et sa performance.
            </p>
          </div>
        </div>

      </div>
    </section><!-- End About Us Section -->

    <!-- ======= Contact Us Section ======= -->
    <section id="contact" class="contact">
      <div class="container">

        <div class="section-title">
          <h2>Me contactez</h2>
        </div>

        <div class="row justify-content-center">

          <div class="col-lg-10">

            <div class="info-wrap">
              <div class="row">
                <div class="col-lg-4 info">
                  <i class="bi bi-geo-alt"></i>
                  <h4>Localisation:</h4>
                  <p>ANTANANARIVO,MADAGASCAR</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                  <i class="bi bi-envelope"></i>
                  <h4>Addresse E-mail:</h4>
                  <p>narihy@gmail.mg</p>
                </div>

                <div class="col-lg-4 info mt-4 mt-lg-0">
                  <i class="bi bi-phone"></i>
                  <h4>Téléphone:</h4>
                  <p>+261 34 12 751 02</p>
                </div>
              </div>
            </div>

          </div>

        </div>

        <div class="row justify-content-center">
          <div class="col-lg-10">
            <form action="{{route('Public.Contact.nous_contacter')}}" method="post" class="php-email-form">
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
          </div>

        </div>

      </div>
    </section><!-- End Contact Us Section -->

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container">
      <div class="copyright">
        &copy; Copyright <strong><span>NARIHY</span></strong>. Tous droit réserver.
      </div>
      <div class="credits">
            Désigner par <a href="">Bootstrap</a>
      </div>
    </div>
  </footer><!-- End #footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('maintenance/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('maintenance/assets/js/main.js')}}"></script>

</body>

</html>

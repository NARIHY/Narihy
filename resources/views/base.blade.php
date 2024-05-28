@php
$user = \Illuminate\Support\Facades\Auth::user();
@endphp
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('titre') | Narihy</title>
  @yield('description')
  @yield('keywords')

  <!-- Favicons -->
  <link href="{{asset('public/assets/img/logo.png')}}" rel="icon">
  {{-- <link href="{{asset('public/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('public/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('public/assets/css/main.css')}}" rel="stylesheet">
  <link href="{{asset('public/assets/css/style.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('myStyle/styles.css')}}">
</head>

<body class="page-index">

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="{{route('Public.base')}}" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="d-flex align-items-center">NARIHY</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a href="{{route('Public.base')}}" @if (request()->routeIs('Public.base')) class="active" @endif >Acceuil</a></li>
          <li><a href="{{route('Public.Propos.acceuil')}}" @if (request()->routeIs('Public.Propos.acceuil')) class="active" @endif >Propos</a></li>
          <li><a href="{{route('Public.Service.acceuil')}}" @if (request()->routeIs('Public.Service.acceuil')) class="active" @endif >Service</a></li>
          <li><a href="{{route('Public.Portfolio.acceuil')}}" @if (request()->routeIs('Public.Portfolio.acceuil')) class="active" @endif >Portfolio</a></li>
          {{-- <li><a href="team.html">Team</a></li> --}}
          <li><a href="{{route('Public.Actualite.acceuil')}}" @if (request()->routeIs('Public.Actualite.acceuil')) class="active" @endif >Actualité</a></li>
          <li><a href="{{route('Public.Blog.acceuil')}}" @if (request()->routeIs('Public.Blog.acceuil')) class="active" @endif >Blog</a></li>
          {{-- <li class="dropdown"><a href="#"><span>Dropdown</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="#">Dropdown 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Deep Dropdown 1</a></li>
                  <li><a href="#">Deep Dropdown 2</a></li>
                  <li><a href="#">Deep Dropdown 3</a></li>
                  <li><a href="#">Deep Dropdown 4</a></li>
                  <li><a href="#">Deep Dropdown 5</a></li>
                </ul>
              </li>
              <li><a href="#">Dropdown 2</a></li>
              <li><a href="#">Dropdown 3</a></li>
              <li><a href="#">Dropdown 4</a></li>
            </ul>
          </li> --}}
          <li><a href="{{route('Public.Contact.acceuil')}}" @if (request()->routeIs('Public.Contact.acceuil')) class="active" @endif>Contact</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->



  <main id="main">

    @yield('contenu')

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    @php
        $facebook = \App\Models\SocialLink::where('type','facebook')->get('lien');
        $twitter = \App\Models\SocialLink::where('type','twitter')->get('lien');
        $instagram = \App\Models\SocialLink::where('type','instagram')->get('lien');
        $linkdin = \App\Models\SocialLink::where('type','linkdin')->get('lien');
    @endphp
    <div class="footer-content">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-5 col-md-12 footer-info">
            <a href="" class="logo d-flex align-items-center">
              <span>NARIHY</span>
            </a>
            <p>
                Envie de me suivre un peu plus, voici divers lien sur mes compte sociale.
            </p>
            <div class="social-links d-flex  mt-3">
                @foreach ($twitter as $item)
                <a href="{{$item->lien}}" target="blank" class="twitter"><i class="bi bi-twitter"></i></a>
                @endforeach
                @foreach ($facebook as $i)
                    <a href="{{$i->lien}}" class="facebook" target="blank" style="background-color: blue"><i class="bi bi-facebook"></i></a>
                @endforeach
                @foreach ($instagram as $i)
                    <a href="{{$i->lien}}" target="blank" class="instagram"><i class="bi bi-instagram"></i></a>
                @endforeach
                @foreach ($instagram as $i)
                <a href="{{$i->lien}}" target="blank" class="linkedin"><i class="bi bi-linkedin"></i></a>
                @endforeach
            </div>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            <h4>Lien utile</h4>
            <ul>
              <li><i class="bi bi-dash"></i> <a href="{{route('Public.base')}}">Acceuil</a></li>
              <li><i class="bi bi-dash"></i> <a href="{{route('Public.Propos.acceuil')}}">Propos</a></li>
              <li><i class="bi bi-dash"></i> <a href="{{route('Public.Service.acceuil')}}">Mes service</a></li>
              <li><i class="bi bi-dash"></i> <a href="#">C.G.U</a></li>
              @if (!$user)
                <li><i class="bi bi-dash"></i> <a href="{{route('Public.Auth.creation_compte')}}">S'inscrire</a></li>
                <li><i class="bi bi-dash"></i> <a href="{{route('Public.Auth.connection')}}">Se connecter</a></li>

                @else
                @if ($user->role_id !== 1)
                    <li><i class="bi bi-dash"></i> <a href="{{route('Administration.tableau_de_bord')}}">Administration</a></li>
                @endif

                <li><i class="bi bi-dash"></i>
                    <form action="{{route('logout')}}" method="post">
                        @csrf
                        <div class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                          <input type="submit" value="Deconnexion" style="background: transparent; border:transparent">
                        </div>

                    </form>
              @endif
              {{-- <li><i class="bi bi-dash"></i> <a href="#">Privacy policy</a></li> --}}
            </ul>
          </div>

          <div class="col-lg-2 col-6 footer-links">
            @php
                $service = \App\Models\Service::orderBy('created_at', 'asc')
                                                ->where('status', '!=', '0')
                                                ->get();
            @endphp
            <h4>Mes service</h4>
            <ul>
                @forelse ($service as $s)
                <li>
                    <i class="bi bi-dash"></i>
                    <a href="#">{{$s->nomService}}</a>
                </li>
                @empty
                <li>
                    Aucune service pour le moment
                </li>
                @endforelse

                {{-- <li><i class="bi bi-dash"></i> <a href="#">Web Development</a></li>
                <li><i class="bi bi-dash"></i> <a href="#">Product Management</a></li>
                <li><i class="bi bi-dash"></i> <a href="#">Marketing</a></li>
                <li><i class="bi bi-dash"></i> <a href="#">Graphic Design</a></li> --}}
            </ul>
          </div>

          <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
            <h4>Me contacter</h4>
            <p>
              ANTANANARIVO<br>
              MADAGASCAR<br>
              AFRIQUE <br><br>
              <strong>Téléphone:</strong> +261 34 12 751 02<br>
              <strong>Email:</strong> narihy@narihy.mg<br>
            </p>

          </div>

        </div>
      </div>
    </div>

    <div class="footer-legal">
      <div class="container">
        <div class="copyright">
          &copy; Copyright <strong><span>Narihy</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
           Template by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
    </div>
  </footer><!-- End Footer --><!-- End Footer -->

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('public/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>


  <!-- Template Main JS File -->
  <script src="{{asset('public/assets/js/main.js')}}"></script>

</body>

</html>

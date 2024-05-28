<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titre')</title>
    <link href="{{asset('public/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/auth.css')}}" rel="stylesheet">
    <link href="{{asset('public/assets/css/main.css')}}" rel="stylesheet">
</head>
<body>
    @yield('contenu')
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
                <a href="index.html" class="logo d-flex align-items-center">
                  <span>NARIHY</span>
                </a>
                <p>Cras fermentum odio eu feugiat lide par naso tierra. Justo eget nada terra videa magna derita valies darta donna mare fermentum iaculis eu non diam phasellus.</p>
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
                  {{-- <li><i class="bi bi-dash"></i> <a href="#">Privacy policy</a></li> --}}
                </ul>
              </div>

              <div class="col-lg-2 col-6 footer-links">
                <h4>Mes service</h4>
                <ul>
                  <li><i class="bi bi-dash"></i> <a href="#">Web Design</a></li>
                  <li><i class="bi bi-dash"></i> <a href="#">Web Development</a></li>
                  <li><i class="bi bi-dash"></i> <a href="#">Product Management</a></li>
                  <li><i class="bi bi-dash"></i> <a href="#">Marketing</a></li>
                  <li><i class="bi bi-dash"></i> <a href="#">Graphic Design</a></li>
                </ul>
              </div>

              <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                <h4>Me contacter</h4>
                <p>
                  ANTANANARIVO<br>
                  MADAGASCAR<br>
                  AFRIQUE <br><br>
                  <strong>Téléphone:</strong> +261 34 12 751 02<br>
                  <strong>Email:</strong> narihy@gmail.mg<br>
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
    <script src="{{asset('public/assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public/assets/vendor/aos/aos.js')}}"></script>
  <!-- Template Main JS File -->
  <script src="{{asset('public/assets/js/main.js')}}"></script>
  <script src="{{asset('public/assets/js/auth.js')}}"></script>
</body>
</html>

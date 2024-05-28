@php
$user = \Illuminate\Support\Facades\Auth::user();
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('titre') | NARIHY</title>

  <!-- Favicons -->
  <link href="{{asset('admin/assets/img/favicon.png')}}" rel="icon">

  <!-- Vendor CSS Files -->
  <link href="{{asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('admin/assets/vendor/simple-datatables/style.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('admin/assets/css/style.css')}}" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">NARIHY</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        {{-- Notifications application --}}
        @php
            $notification_count = \App\Models\Notification::whereDate('created_at', \Carbon\Carbon::today())
                                                                ->count();
            $e = "";
            if ($notification_count < 2){
                $e ="notification";
            } else {
                $e = "notifications";
            }
            $notification = \App\Models\Notification::whereDate('created_at', \Carbon\Carbon::today())
                                                            ->orderBy('created_at','desc')
                                                            ->limit(5)
                                                            ->get();

        @endphp
        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">
                {{$notification_count}}
            </span>
          </a><!-- End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              Vous avez {{$notification_count}} {{$e}}
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            @forelse ($notification as $notif)
            @php
                $date = \Carbon\Carbon::parse($notif->created_at)->diffForHumans();
            @endphp
                <li class="notification-item">
                        <?= $notif->icons ?>
                        <div>
                            <h4>
                                {{$notif->titre}}
                            </h4>
                            <p>
                                {{$notif->contenu}}
                            </p>
                            <p>
                                {{$date}}
                            </p>
                        </div>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>
            @empty
                <li class="notification-item">
                    <div>
                        <h4>NOTIFICATION</h4>
                        <p>
                            Aucune notification pour le moment.
                        </p>
                        <p>actuellement</p>
                    </div>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>
            @endforelse


            <li class="dropdown-footer">
              <a href="#">Voir toutes</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        {{-- <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav --> --}}

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{asset('admin/assets/img/profile-img.jpg')}}" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">
                {{$user->username}}
            </span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>
                    {{$user->prenon}} {{$user->nom}}
              </h6>
              <span>
                {{$user->role->status}}
              </span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="{{route('Administration.Profile.mon_compte')}}">
                <i class="bi bi-person"></i>
                <span>Mon profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-gear"></i>
                <span>Parametre</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            {{-- <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
--}}
            <li>
                <form action="{{route('logout')}}" method="post">
                    @csrf
                    <div class="dropdown-item d-flex align-items-center">
                        <i class="bi bi-box-arrow-right"></i>
                      <input type="submit" value="Log out" style="background: transparent; border:transparent">
                    </div>

                </form>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a @if (request()->routeIs('Administration.tableau_de_bord')) class="nav-link " @else class="nav-link collapsed" @endif  href="{{route('Administration.tableau_de_bord')}}">
          <i class="bi bi-grid"></i>
          <span>Tableau de bord</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a @if (request()->routeIs('Administration.Blog.liste_les_blogs')) class="nav-link " @else class="nav-link collapsed" @endif href="{{route('Administration.Blog.liste_les_blogs')}}">
            <i class="bi bi-diagram-3-fill"></i>
          <span>Blog</span>
        </a>
      </li>
      {{-- Blog --}}
      @if($user->role_id === 4)
      <li class="nav-item">
        <a @if (request()->routeIs('Administration.Service.liste_service')) class="nav-link " @else class="nav-link collapsed" @endif href="{{route('Administration.Service.liste_service')}}">
            <i class="bi bi-gear-fill"></i>
          <span>Services</span>
        </a>
      </li>
      @endif
      {{-- Service --}}
        @if($user->role_id === 4)
            <li class="nav-item">
                <a @if (request()->routeIs('Administration.Actualite.liste_des_actualite')) class="nav-link " @else class="nav-link collapsed" @endif  href="{{route('Administration.Actualite.liste_des_actualite')}}">
                    <i class="bi bi-pin-angle-fill"></i>
                <span>Actualités</span>
                </a>
            </li>
        @endif
      {{-- Actualite --}}
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#portfolio" data-bs-toggle="collapse" href="#">
            <i class="bi bi-star-fill"></i><span>Portfolio</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="portfolio" class="nav-content collapse " data-bs-parent="#sidebar-nav">

          <li>
            <a href="{{route('Administration.Portfolio.Categorie.liste_category_portfolio')}}">
              <i class="bi bi-circle"></i><span>Catégorie</span>
            </a>
          </li>
          <li>
            <a href="{{route('Administration.Portfolio.MesPortfolio.lister_portfolio')}}">
              <i class="bi bi-circle"></i><span>Liste de mes portfolio</span>
            </a>
          </li>
        </ul>
      </li>
      {{-- Portfolio --}}
      @if($user->role_id === 4)
        <li class="nav-item">
            <a @if (request()->routeIs('Administration.Contacte.liste_contacte')) class="nav-link " @else class="nav-link collapsed" @endif href="{{route('Administration.Contacte.liste_contacte')}}">
                <i class="bi bi-telephone-inbound-fill"></i>
            <span>Contact</span>
            </a>
        </li>
      @endif
      {{-- Contacte --}}

      @if ($user->role_id !== 2)
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-emoji-smile"></i><span>Gestion des comptes</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">

            <li>
                <a href="{{route('Administration.GestionCompte.Role.liste_role')}}">
                <i class="bi bi-circle"></i><span>Role</span>
                </a>
            </li>
            <li>
                <a href="{{route('Administration.GestionCompte.Compte.liste_compte')}}">
                <i class="bi bi-circle"></i><span>Liste des comptes</span>
                </a>
            </li>
            </ul>
        </li><!-- End Components Nav -->
      @endif



      <li class="nav-heading">Pages</li>

      @if ($user->role_id === 4)
        <li class="nav-item">
            <a @if (request()->routeIs('Administration.Publiciter.liste_publicite')) class="nav-link " @else class="nav-link collapsed" @endif  href="{{route('Administration.Publiciter.liste_publicite')}}">
            <i class="bi bi-patch-plus"></i>
            <span>Publicités</span>
            </a>
        </li><!-- End Profile Page Nav -->
      @endif

      @if ($user->role_id === 4)
        <li class="nav-item">
            <a @if (request()->routeIs('Administration.SocialLinks.social_link')) class="nav-link " @else class="nav-link collapsed" @endif href="{{route('Administration.SocialLinks.social_link')}}">
            <i class="bi bi-link-45deg"></i>
            <span>Link sociale</span>
            </a>
        </li><!-- End Profile Page Nav -->
      @endif
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{route('Public.base')}}">
          <i class="bi bi-flower3"></i>
          <span>Site</span>
        </a>
      </li><!-- End Profile Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    @yield('pagetitle')
    {{-- <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title --> --}}

    <section class="section dashboard">
        @yield('contenu')
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('admin/assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('admin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('admin/assets/vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('admin/assets/vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('admin/assets/vendor/quill/quill.min.js')}}"></script>
  <script src="{{asset('admin/assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('admin/assets/vendor/tinymce/tinymce.min.js')}}"></script>
  <script src="{{asset('admin/assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('admin/assets/js/main.js')}}"></script>

</body>

</html>

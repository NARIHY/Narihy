<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>404 - Page introuvable</title>


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

  <main>
    <div class="container">

      <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
        <h1>404</h1>
        <h2>
            La page que vous tentez de joindre n'éxiste pas.
        </h2>
        <a class="btn" href="{{route('Administration.tableau_de_bord')}}">Retour vers l'acceuil</a>
        <img src="{{asset('admin/assets/img/not-found.svg')}}" class="img-fluid py-5" alt="Page Not Found">
        <div class="credits">

          Designed by <a href="https://bootstrapmade.com/">Bootstrap</a>
        </div>
      </section>

    </div>
  </main><!-- End #main -->

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

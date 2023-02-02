<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sequences.ai') }} - @yield('page-title')</title>

  
    <!-- icons -->
    <!-- <link rel="stylesheet" href="//cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.4.55/css/materialdesignicons.min.css" integrity="sha512-6ftzZvH15uxye8mFPuNyF/2F8ESEWElTVS6G9S7YD+cdHRlxZQeEV8Mn+YOma5BWJiEzeM0g9vhH7hbzFkQuvg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">


    <!-- Admin theme Styles -->
    <link href="{{ asset('admin-assets/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <!-- custom app styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" /> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" integrity="sha512-yI2XOLiLTQtFA9IYePU0Q1Wt0Mjm/UkmlKMy4TU4oNXEws0LybqbifbO8t9rEIU65qdmtomQEQ+b3XfLfCzNaw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/css/bootstrap-select.min.css" integrity="sha512-z13ghwce5srTmilJxE0+xd80zU6gJKJricLCq084xXduZULD41qpjRE9QpWmbRyJq6kZ2yAaWyyPAgdxwxFEAg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css"> -->


    <!-- DataTable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.css"/>

    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqtree/1.6.0/jqtree.css" integrity="sha512-APVGR7odrDwdn9fJEmwVlyAHSgELR6FVre6yfffAxsJpacpURU2UVwIvJ11g4k3lPfcLiJCrjcc7PzDtiXzhHQ==" crossorigin="anonymous" />
    <!-- link to shepherd CSS -->
    <link rel="stylesheet" href="{{ asset('css/shepherd.css') }}">
    <style>
      /* .tour-h { display: none} */
    </style>

    <!-- Page level styles -->
    @stack('styles')

    <style>

      .swal2-container {
        z-index: 2000 !important;
      } 

      .topbar .dropdown-list .dropdown-header {
        background-color: #F48020 !important;
        border: 1px solid #F48020 !important;
      }

      .img {
            width: 480px;
        }

        .img img {
            max-width: 100%;
        }

       
        .select2-container--default .select2-results>.select2-results__options {
            max-height: 400px !important;
        }

        select {
            background-position: right -5px center;
        }

        #fleets-selection {
            width: 300px;
        }

        .foption {
            padding-bottom: 8px;
            border-bottom: 2px solid #B8A009;
        }

        .flabel {
            font-size: 19px;
            font-weight: bold;
            text-align: center;
        }

        .select2-container--default .select2-results__option {
            background-color: #fff;
            color: #000;
        }

        .select2-container--default img {
          max-width: 280px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #B8A009;
            color: #000;
        }

    </style>

</head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="app">
    <div id="wrapper">

     <!-- Sidebar -->
      @include('admin.partials.sidebar')
     <!-- End of Sidebar -->
 
     <!-- Content Wrapper -->
     <div id="content-wrapper" class="d-flex flex-column">
 
       <!-- Main Content -->
       <div id="content">
 
         <!-- Topbar -->
         @include('admin.partials.topbar')
         <!-- End of Topbar -->
 
         <!-- Begin Page Content -->
         <div class="container-fluid">
 
             @yield('main-content')
 
         </div>
         <!-- /.container-fluid -->
 
       </div>
       <!-- End of Main Content -->
 
       <!-- Footer -->
       @include('admin.partials.footer')
       <!-- End of Footer -->

       @yield('off-screen')

     </div>
     <!-- End of Content Wrapper -->
   </div>
  </div>

 
 
  <!-- End of Page Wrapper -->

    <!-- updated -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script src="{{ asset('admin-assets/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('admin-assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Admin theme Custom script for all pages-->
    <script src="{{ asset('admin-assets/js/sb-admin-2.min.js') }}"></script>

    <!-- Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.21/af-2.3.5/b-1.6.2/b-colvis-1.6.2/b-flash-1.6.2/b-html5-1.6.2/b-print-1.6.2/cr-1.5.2/fc-3.3.1/fh-3.1.7/kt-2.5.2/r-2.2.5/rg-1.1.2/rr-1.2.7/sc-2.0.2/sp-1.1.1/sl-1.3.1/datatables.min.js"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js" integrity="sha512-qiKM6FJbI5x5+GL5CEbAUK0suRhjXVMRXnH/XQJaaQ6iQPf05XxbFBE4jS6VJzPGIRg7xREZTrGJIZVk1MLclA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  
    <!-- sweetalert2 -->
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.all.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/9.17.1/sweetalert2.all.min.js" integrity="sha512-WJ8BK+w0M8i3F6DlbF8XnIyEwCgqXHKpkYHpVsr8oI9dDtJcTDziUTsRu1fIEkGJ36p1FSUvUXZUtI8qJdVSGA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.20.0/axios.min.js"></script>

    <script src="{{ asset('admin-assets/js/moment.min.js') }}"></script>

    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.14/js/bootstrap-select.min.js" integrity="sha512-CJXg3iK9v7yyWvjk2npXkQjNQ4C1UES1rQaNB7d7ZgEVX2a8/2BmtDmtTclW4ial1wQ41cU34XPxOw+6xJBmTQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('js/cropper.min.js') }}"></script>


          <!-- javascript deliver cdn for tour of shepherd -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/shepherd.js@5.0.1/dist/js/shepherd.js"></script> -->
    <script src="{{ asset('js/shepherd.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqtree/1.6.0/tree.jquery.js" integrity="sha512-5iFOizc4HXbadGBYsgb3LVWuSy6BW9PLgXtmVeXJJU0kJyFfFyHTfdGHOS34OeBwiUZGTHv+biEx4g/+IzorXA==" crossorigin="anonymous"></script>


    <script>

       window.Toast = Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          onOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
          }
      });

    </script>
    

    <!-- Page Level Scripts -->
    @stack('scripts')

</body>
</html>

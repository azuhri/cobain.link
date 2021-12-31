<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap 4.6 CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap4-6.css')}}">
    <link rel="stylesheet" href="{{asset('css/app.css')}}">

    <title>cobain.Link | @yield('title')</title>
  </head>
  <body>
    <div class="container-fluid vh-95 d-flex justify-content-center align-items-center" id="app">
        @yield('content')
    </div>

    <footer class="mb-4">
        Copyright &copy; 2021 azuhri-dev | All Right Reserved | source code at : <a href="https://github.com/azuhri/cobain.link.git" target="_blank">https://github.com/azuhri/cobain.link.git</a>
    </footer>

    <!-- Jquery 3.6 JS -->
    <script src="{{asset('js/jquery3-6.js')}}"></script>
    <!-- Bootstrap 4.6 JS -->
    <script src="{{asset('js/bootstrap4-6.js')}}"></script>
    <!-- QRCODE JS -->
    <script src="{{asset('js/qrcode.js')}}"></script>
    <!-- SWEET ALERT JS -->
    <script src="{{asset('js/sweetalerts2.js')}}"></script>
    <!-- HTML2CANVAS JS -->
    <script src="{{asset('js/html2canvas.js')}}"></script>
    <!-- BLADE JS -->
    @yield('js')
    <!-- APP JS -->
    <script src="{{asset('js/app.js')}}"></script>
  </body>
</html>

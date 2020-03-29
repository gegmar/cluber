<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="/vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="/vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="/css/fontastic.css">
    <!-- Seat-Charts css -->
    <link rel="stylesheet" href="/vendor/jquery.seat-charts/css/jquery.seat-charts.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- Summernote CSS-->
    <link rel="stylesheet" href="/vendor/summernote/summernote-bs4.css">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="/css/style.{{ config('app.color_schema') }}.premium.css" id="theme-stylesheet">
    <!-- DataTables CSS-->
    <link rel="stylesheet" href="/vendor/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/vendor/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="/css/custom.css">
    <!-- Favicon-->
    <link rel="shortcut icon" href="/img/favicon.ico">
    <!-- Tweaks for older IEs-->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->

</head>

<body>
    @yield('site-content')
    <!-- JavaScript files-->
    <script src="/vendor/jquery/jquery.min.js">
    </script>
    <script src="/vendor/popper.js/umd/popper.min.js">
    </script>
    <script src="/vendor/bootstrap/js/bootstrap.min.js">
    </script>
    <script src="/vendor/jquery.cookie/jquery.cookie.js">
    </script>
    <script src="/vendor/chart.js/Chart.min.js">
    </script>
    <script src="/vendor/jquery-validation/jquery.validate.min.js">
    </script>
    <script src="/vendor/jquery.seat-charts/js/jquery.seat-charts.min.js">
    </script>
    <script src="/vendor/messenger-hubspot/build/js/messenger.min.js"> </script>
    <script src="/vendor/messenger-hubspot/build/js/messenger-theme-flat.js"> </script>
    <!-- Main File-->
    <script src="/js/front.js">
    </script>
    <script type="text/javascript">
        Messenger.options = {
            extraClasses: 'messenger-fixed messenger-on-top  messenger-on-right',
            theme: 'flat',
            messageDefaults: {
                showCloseButton: true
            }
        }
        @if (session('status'))
            Messenger().post({
                message: "{{ session('status') }}",
                type: 'error',
                showCloseButton: true
            });
        @endif

        @foreach($errors->all() as $error)
        Messenger().post({
            message: '{{ $error }}',
            type: 'error',
            showCloseButton: true
        });
        @endforeach
    </script>
    @yield('custom-js')
</body>

</html>
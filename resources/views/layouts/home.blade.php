<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    {{--<meta name="viewport" content="width=750,user-scalable=no,target-densitydpi=device-dpi">--}}
    @yield('selfmeta')

    <title>@yield('title')</title>

    <!-- Fonts -->
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>--}}

    <!-- Styles -->

    <!-- Self Styles -->
    @yield('selfcss')

    <!-- JavaScripts -->
    <script src="{{ $qiniu_cdn_path }}/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script type="application/javascript">
        var imagespath = '{{ asset('images') }}';
    </script>
    <script src="{{ $qiniu_cdn_path }}/js/common.js?id=1" type="text/javascript"></script>
</head>
<body class="bg-brown">
<!-- Header -->


<!-- Content -->
@yield('content')

<!-- Footer -->
@include($footer)

<!-- Modal -->
@include($modal)

<!-- Self JavaScripts -->
@yield('selfjs')
</body>
</html>
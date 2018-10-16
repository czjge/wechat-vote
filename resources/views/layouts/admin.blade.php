<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="_token" content="{{ csrf_token() }}"/>

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}">
    <!-- Google Font -->
    <link rel="stylesheet" href="{{ asset('fonts/google-fonts/fonts.css') }}">

    <!-- Theme Style -->
    <link rel="stylesheet" href="{{ asset('css/skins/' . config('admin.skin') . '.min.css') }}">

    <!-- Required Css -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datetimepicker/css/bootstrap-datetimepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/iCheck/all.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-fileinput/css/fileinput.min.css') }}" media="all" type="text/css" />
    <link rel="stylesheet" href="{{ asset('plugins/nprogress/nprogress.css') }}">

    <!-- Required Js -->
    <script src="{{ asset('plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/jQuery-pjax/jquery.pjax.js') }}"></script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">

<div class="wrapper">

    <!-- Header -->
    @include('layouts.header')

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Content -->
    <div class="content-wrapper">

        <section class="content" id="pjax-container">

            @include('layouts.form_warning')

            <section class="content-header">
                {{-- we include the following h1 html mark to hold the tabel style, avoiding the table cover the breadcrumb.--}}
                <h1 style="visibility: hidden;">&nbsp;</h1>
                <?php echo Crumbs::render();?>
            </section>

            <!-- Main Content -->
            @yield('content')

            @include('layouts.script')

        </section>

    </div>

    <!-- Footer -->
    @include('layouts.footer')
    @include('layouts.modal')

</div>

<script src="{{ asset('js/AdminLTE.min.js') }}"></script>
<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/common.js') }}"></script>
<script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
<script src="{{ asset('plugins/datetimepicker/js/bootstrap-datetimepicker.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-fileinput/js/locales/zh.js') }}"></script>
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('plugins/noty/jquery.noty.packaged.min.js') }}"></script>
<script src="{{ asset('plugins/nprogress/nprogress.js') }}"></script>
<script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/select2/i18n/zh-CN.js') }}"></script>
<script>
    // noty settings.
    $.noty.defaults.layout = 'topRight';
    $.noty.defaults.theme = 'relax';

    // pjax settings.
    $(document).pjax('a:not(a[target="_blank"])', {
        timeout: 5000,
        container: '#pjax-container'
    });

    $(document).on('pjax:start', function() {
        NProgress.configure({
            template: '<div class="bar" role="bar" style="background: red"><div class="peg" style="box-shadow: 0 0 10px #fff, 0 0 5px #fff;"></div></div><div class="spinner" role="spinner"><div class="spinner-icon" style="border-top-color:white;border-left-color: white"></div></div>'
        });
        NProgress.start();
    });

    $(document).on('pjax:end', function() {
        NProgress.done();
    });

    $(document).on("pjax:timeout", function(event) {
        // 阻止超时导致链接跳转事件发生
        event.preventDefault()
    });

    $(document).on('submit', 'form[pjax-container]', function(event) {
        $.pjax.submit(event, '#pjax-container')
    });

//    $(document).on('pjax:error', function(event, xhr) {
//
//        var message = '';
//
//        try{
//            response = JSON.parse(xhr.responseText);
//            message = response.message || 'error';
//        }catch(e){
//
//            if (xhr.status == 0) {
//                return;
//            }
//
//            noty({
//                text: "<strong>Warning!</strong><br/>"+xhr.statusText,
//                type:'warning',
//                timeout: 5000
//            });
//            return false;
//        }
//
//        if (message) {
//            noty({
//                text: "<strong>Warning!</strong><br/>"+message,
//                type:'warning',
//                timeout: 5000
//            });
//        }
//
//        return false;
//    });

    $(document).on("pjax:popstate", function() {
        $(document).one("pjax:end", function(event) { // one() 为每个匹配元素的一个或多个事件绑定一次性事件处理函数
            $(event.target).find("script[data-exec-on-pjax-popstate]").each(function() { // event.target 显示哪个 DOM 元素触发了事件
                $.globalEval(this.text || this.textContent || this.innerHTML || ''); // $.globalEval() 全局性地执行一段JavaScript代码
            });
        });
    });
</script>
</body>
</html>
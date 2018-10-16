<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>刷票程序</title>

    <!-- Fonts -->
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>--}}
    {{--<link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>--}}

    <!-- Styles -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

    <!-- Self Styles -->

    <style>
        body {
            font-family: 'Lato';
        }

        .fa-btn {
            margin-right: 6px;
        }
    </style>
</head>
<body id="app-layout">
<!-- Header -->


<!-- Content -->
<section class="add_form_box clearfix">
    <div class="add_form_box_main clearfix">
        <form id="regFrom_doc" method="post" enctype="multipart/form-data" name="doc">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="30%">
                        <label class="c1">刷票人编号</label>
                    </td>
                    <td>
                        <input type="text" class="input_class" name="no" id="no" />
                    </td>
                </tr>

                <tr>
                    <td>
                        <label class="c1">刷的票数</label>
                    </td>
                    <td>
                        <input type="text" class="input_class" name="num" id="num" />
                    </td>
                </tr>
            </table>
            <input  class="doc_add_form_btn btn_class" type="button" value="提交" />
        </form>
    </div>
</section>

<!-- Footer -->


<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}

<!-- Self JavaScripts -->
<script type="application/javascript">
    $(function () {

        // candidate sign up.
        $(".doc_add_form_btn").click( function () {
            var no = $("#no").val();
            var num = $("#num").val();

            if(no == ""){
                tusi("编号no不能为空");
                return false;
            }
            if(num == ''){
                tusi("票数不能为空");
                return false;
            }
            demo(no,num);
        });

        function demo(no,num){
            if(num>0){
                var nums = Number(num)-5;
                var times = Date.parse(new Date());

                $.ajax({
                    type: "GET",
                    url: "{{ route('home.brush.getDoIndex') }}",
                    data: {'no':no},

                    success: function(msg){
                        if(msg.code == 1){
                            console.log('剩余票数：',nums);
                            setTimeout(function(){demo(no,nums);}, 1000);
                        }else{
                            console.log('失败了',msg.t);
                            setTimeout(function(){demo(no,num);}, 1000);
                        }
                    }
                });
            }
        }
    });
</script>
</body>
</html>


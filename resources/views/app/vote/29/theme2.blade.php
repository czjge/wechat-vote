@extends('layouts.home')


<?php $footer = 'app.vote.'.$id.'.footer';?>
<?php $modal = 'app.vote.'.$id.'.modal';?>

@section('selfmeta')
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
@endsection

@section('title')
    {{ $vote->title }}
@endsection

@section('selfcss')
    <link href="{{ $qiniu_cdn_path }}/css/vote/{{ $vote->id }}/style.css" rel="stylesheet" type="text/css">

    <script type="text/javascript">
        document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + 'px';
    </script>
@endsection

@section('content')
    <div class="board-head"></div>
    <ul class="j-con">
    </ul>
@endsection


@section('selfjs')
    <script src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js" type="text/javascript"></script>
    <script src="{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/script.js" type="text/javascript"></script>
    <script>
        var resultArray;
        $(function () {
            var arr;
            $.ajax({
                url: '{{ $qiniu_cdn_path }}/js/vote/{{ $vote->id }}/data.text',
                data: '',
                success: function (data) {
                    arr = JSON.parse(data);
                    mySort(arr);
                    var aHtml = '';
                    var bHtml = '';
                   if (arr.length > 0){
                       for (var  i = 0; i < 2; i++){
                           var res = arr[i];
                           aHtml = '<li>'+
                                    '<div class="j-img"><img src="https://cdn.mp.doctorofsc.cn/other/20180921/'+ res.name +'.jpg"> </div>'+
                                    '<div class="j-name">'+ res.name +'</div> '+
                                    '<div class="j-info">'+ res.hos +'</div> '+
                                    '<div class="j-desc">'+ res.desc +'</div> '+
                                    '</li>';

                           $('.j-con').append(aHtml)
                       };
                       for (var  i = 0; i < resultArray.length; i++){
                           var res = resultArray[i];
                           bHtml = '<li>'+
                               '<div class="j-img"><img src="https://cdn.mp.doctorofsc.cn/other/20180921/'+ res.name +'.jpg"> </div>'+
                               '<div class="j-name">'+ res.name +'</div> '+
                               '<div class="j-info">'+ res.hos +'</div> '+
                               '<div class="j-desc">'+ res.desc +'</div> '+
                               '</li>';

                           $('.j-con').append(bHtml)
                       };

                   }
                },
                error: function () {
                    console.log(1)
                }

            });

        });
        function mySort(e) {
            var arr =e.splice(2);
            resultArray = arr.sort(
                function compareFunction(param1, param2) {
                    return param1.name.localeCompare(param2.name,"zh");
                }
            );
        }


        $('.report').click(function () {  //风险报告
            $('.report_box').removeClass('box_hide');
        });
        $('.check-opt').click(function () {
            if($('.check-box').hasClass('checked')){
                $('.check-box').removeClass('checked');
                $('.btn-sure').addClass('bg-gray');
            }else {
                $('.check-box').addClass('checked');
                $('.btn-sure').removeClass('bg-gray');
            }
        })
        $('.reg-sex').click(function () {  //性别
            $(this).parent().find(".select-box").removeClass('selected');
            $(this).find('.select-box').addClass('selected');
        });

        $('.parent-sex').click(function () {  //家长性别
            $(this).parent().find(".select-box").removeClass('selected');
            $(this).find('.select-box').addClass('selected');
        });
        $('.group-age').click(function () {  //分组
            $(this).parent().find(".select-box").removeClass('selected');
            $(this).find('.select-box').addClass('selected');
        });
        $(document).on('click','.mara-reg-rules',function () {
            $('.usual_box').removeClass('box_hide');
        });

        function closeRules(e) {
            $(e).parent().addClass('box_hide');
        }
    </script>



@endsection

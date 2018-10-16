<script data-exec-on-pjax-popstate>

    $(function () {

        // datetimepicker.
        if ($('.datetimepicker').length > 0) {
            $('.datetimepicker').datetimepicker({
                format: 'yyyy-mm-dd hh:ii:ss'
                //minuteStep: 1
            });
        }
        if ($('.datetimepicker_vote_time').length > 0) {
            $('.datetimepicker_vote_time').datetimepicker({
                format: 'hh:ii:ss',
                startView: 1,
                //minuteStep: 1
            });
        }

        // icheck.
        if ($('input[type="radio"].minimal').length > 0) {
            $('input[type="radio"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        }
        if ($('input[type="checkbox"].minimal').length > 0) {
            $('input[type="checkbox"].minimal').iCheck({
                checkboxClass: 'icheckbox_minimal-blue',
                radioClass: 'iradio_minimal-blue'
            });
        }

        // select2.
        if ($('.select2').length > 0) {
            $(".select2").select2({'language': 'zh-CN'});
        }

        // hospital and department.
        if ($('.select2-hospital').length > 0) {
            $(".select2-hospital").select2({'language': 'zh-CN'}).change(function () {
                $('.select2-department').empty();
                var hid = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/admin/doctor/ajax-deps/"+hid,
                    //data: {username:$("#username").val(), content:$("#content").val()},
                    dataType: "json",
                    success: function(data){
                        for (var k in data) {
                            //console.log(data[k]['text'])
                            var option	= '<option value="'+data[k]['id']+'">'+data[k]['text']+'</option>';
                            $('.select2-department').append(option);
                        }
                    }
                });
            });
        }
        if ($('.select2-department').length > 0) {
            $(".select2-department").select2({'language': 'zh-CN'});
        }

        // doctor adept_tag.
        if ($('.select2-adept_tag').length > 0) {
            $(".select2-adept_tag").select2(
                {'language': 'zh-CN','tags': true}
            ).change(function () {
                var tagArr = $(this).val();
                if (tagArr==null) {return;}
                var name = tagArr.pop();

                $.ajax({
                    type: "GET",
                    url:"/admin/doctor/ajax-add-tag/"+name,
                    dataType: "json",
                    success: function(data){}
                });

            });
        }

        // family-doctor community and team.
        if ($('.select2-community').length > 0) {
            $(".select2-community").select2({'language': 'zh-CN'}).change(function () {
                $('.select2-team').empty();
                var cid = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "/admin/fd-doctor/ajax-teams/"+cid,
                    //data: {username:$("#username").val(), content:$("#content").val()},
                    dataType: "json",
                    success: function(data){
                        for (var k in data) {
                            //console.log(data[k]['text'])
                            var option	= '<option value="'+data[k]['id']+'">'+data[k]['text']+'</option>';
                            $('.select2-team').append(option);
                        }
                    }
                });
            });
        }
        if ($('.select2-team').length > 0) {
            $(".select2-team").select2({'language': 'zh-CN'});
        }

        // family-doctor paid_service_tag.
        if ($('.select2-paid_service_tag').length > 0) {
            $(".select2-paid_service_tag").select2(
                {'language': 'zh-CN','tags': true}
            ).change(function () {
                var tagArr = $(this).val();
                if (tagArr==null) {return;}
                var name = tagArr.pop();

                $.ajax({
                    type: "GET",
                    url:"/admin/fd-community/ajax-add-tag?name="+encodeURI(name)+"&type=1",
                    dataType: "json",
                    success: function(data){}
                });

            });
        }

        // family-doctor unpaid_service_tag.
        if ($('.select2-unpaid_service_tag').length > 0) {
            $(".select2-unpaid_service_tag").select2(
                {'language': 'zh-CN','tags': true}
            ).change(function () {
                var tagArr = $(this).val();
                if (tagArr==null) {return;}
                var name = tagArr.pop();

                $.ajax({
                    type: "GET",
                    url:"/admin/fd-community/ajax-add-tag?name="+encodeURI(name)+"&type=2",
                    dataType: "json",
                    success: function(data){}
                });

            });
        }

        // doctor schedule time.
        if ($('.scheduleTime').val() != '' && $('.scheduleTime').val() != undefined) {
            var temp = $('.scheduleTime').val().split('@');
            for (var j=0;j<temp.length;j++) {
                for (var i=0;i<$('.edit-avail').length;i++) {
                    if ($($('.edit-avail')[i]).data('n') == temp[j]) {
                        $($('.edit-avail')[i]).append('V');
                    }
                }
            }
        }

        // bootstrap-fileinput.
        if ($('.fileupload').length > 0) {

            $('.fileupload').each(function () {

                var fileUploadOptions = {
                    //showUpload: false,
                    uploadUrl: '{{ route("admin.file.postUploadFile") }}',
                    language: 'zh',
                    uploadExtraData: {
                        _token: "{{ csrf_token() }}"
                    },
                    dropZoneEnabled: false,
                    allowedFileExtensions : [ 'jpg', 'png']
                };

                var imageurl = $(this).attr("value");

                if (imageurl) {
                    var imgurl = imageurl.indexOf("http") > -1 ?
                    "<img src='" + imageurl + "' class='file-preview-image' width='200'>" :
                    "<img src='/storage/" + imageurl + "' class='file-preview-image' width='200'>";

                    fileUploadOptions = $.extend({
                        initialPreview: [imgurl]
                    }, fileUploadOptions);
                }

                $(this).fileinput(fileUploadOptions).on("fileuploaded", function (event, data, previewId, index) {
                    var thisimgdiv = $(this).parents('.form-group').children('.img-div');
                    thisimgdiv.empty().append("<input type='hidden' name='"+thisimgdiv.data('name')+"' value='"+data.response.url+"'/>");
                });
            });

        }

        // video upload
        if ($('.fileupload_video').length > 0) {

            $('.fileupload_video').each(function () {

                var fileUploadOptions = {
                    //showUpload: false,
                    //enctype: 'multipart/form-data',
                    uploadUrl: '{{ route("admin.file.postUploadVideo") }}',
                    language: 'zh',
                    uploadExtraData: {
                        _token: "{{ csrf_token() }}"
                    },
                    dropZoneEnabled: false,
                    allowedFileExtensions : ['mp4']
                };

                var videourl = $(this).attr("value");

                if (videourl) {
                    var videurl = videourl.indexOf("http") > -1 ?
                        "<video src='" + videourl + "' class='file-preview-image' width='200'></video>" :
                        "<video src='/storage/" + videourl + "' class='file-preview-image' width='200'></video>";

                    fileUploadOptions = $.extend({
                        initialPreview: [videurl]
                    }, fileUploadOptions);
                }

                $(this).fileinput(fileUploadOptions).on("fileuploaded", function (event, data, previewId, index) {
                    //var thisimgdiv = $(this).parents('.form-group').children('.img-div');
                    var thisvideodiv = $(this).parents('.form-group').children('.video-div');
                    //thisimgdiv.empty().append("<input type='hidden' name='"+thisimgdiv.data('name')+"' value='"+data.response.url+"'/>");
                    thisvideodiv.empty().append("<input type='hidden' name='"+thisvideodiv.data('name')+"' value='"+data.response.url+"'/>");
                });
            });

        }

        // chart.js.
        if ($("#lineChart").length > 0) {
            var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
            var lineChart = new Chart(lineChartCanvas);

            var lineChartData = {
                labels: <?php echo str_replace('&quot;', '', isset($days) ? $days : 0);?>,
                datasets: [
                    {
                        label: "Digital Goods",
                        fillColor: "rgba(60,141,188,0.9)",
                        strokeColor: "rgba(60,141,188,0.8)",
                        pointColor: "#3b8bba",
                        pointStrokeColor: "rgba(60,141,188,1)",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(60,141,188,1)",
                        data: <?php echo isset($votes) ? $votes : 0;?>
                    }
                ]
            };

            var lineChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: "rgba(0,0,0,.05)",
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
                //String - A legend template
                legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true
            };

            //Create the line chart
            lineChartOptions.datasetFill = false;
            lineChart.Line(lineChartData, lineChartOptions);
        }


    });
</script>
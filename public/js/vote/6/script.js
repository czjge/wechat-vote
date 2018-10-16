// 关注二维码
var shareGuideFlag = 0;
function showShareGuide(){
	if (shareGuideFlag == 1) {
		return;
	}
	$('body').append('<div id="share_guide_box" onclick="hideShareGuide();" style="position:fixed;z-index:80;left:0px;top:0px;width:100%;height:100%;background-color: rgba(0,0,0,0.8);text-align:right;" ontouchmove="return true;" ><img src="'+imagespath+'/scmy_qrcode.jpg"></div>');
	shareGuideFlag = 1;
}
function hideShareGuide(){
	$("#share_guide_box").remove();
	shareGuideFlag = 0;
}

// 底部菜单搜索
$(document).on('click', '.footer_nav_search', function () {
	$(window).scrollTop(0);
	$(".search_box").removeClass('box_hide');
});
$(document).on('click', '.search_close_box', function () {
	$(".search_box").addClass('box_hide');
});


//活动规则
$(document).on('click', '.rule_info', function () {
    $("#videoBox").addClass('box_hide');
	$(".rule_box").removeClass('box_hide');
});
$(document).on('click', '.rule_box_close', function () {
    $("#videoBox").removeClass('box_hide');
	$(".rule_box").addClass('box_hide');
});

$(document).on('click', '.main_btn_box_close', function () {
	$(".main_btn_box").addClass('box_hide');
});

// 倒计时
/*$(document).on('click', '.list_item', function () {
	var EndTime= new Date('2017/01/25 00:00:00');
	var NowTime = new Date();
	var t =EndTime.getTime() - NowTime.getTime();
	var d=0;
	var h=0;
	var m=0;
	var s=0;

	if(t>=0){
		d=Math.floor(t/1000/60/60/24);
		h=Math.floor(t/1000/60/60%24);
		m=Math.floor(t/1000/60%60);
		//s=Math.floor(t/1000%60);
	}

	document.getElementById("_t_d").innerHTML = d;
	document.getElementById("_t_h").innerHTML = h;
	document.getElementById("_t_m").innerHTML = m;

	$(".count_down_box").removeClass('box_hide');
});
$(document).on('click', '.count_down_close_box', function () {
	$(".count_down_box").addClass('box_hide');
});
function GetRTime(){
	var EndTime= new Date('2017/01/25 00:00:00');
	var NowTime = new Date();
	var t =EndTime.getTime() - NowTime.getTime();
	var d=0;
	var h=0;
	var m=0;
	var s=0;

	if(t>=0){
		d=Math.floor(t/1000/60/60/24);
		h=Math.floor(t/1000/60/60%24);
		m=Math.floor(t/1000/60%60);
		//s=Math.floor(t/1000%60);
	}

	document.getElementById("t_d").innerHTML = d;
	document.getElementById("t_h").innerHTML = h;
	document.getElementById("t_m").innerHTML = m;
	//document.getElementById("t_s").innerHTML = s + "秒";
}*/
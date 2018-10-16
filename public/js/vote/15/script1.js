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
	$(".rule_box").removeClass('box_hide');
});
$(document).on('click', '.rule_box_close', function () {
	$(".rule_box").addClass('box_hide');
});
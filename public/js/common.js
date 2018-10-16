function highLightMenu(obj){
    var leftbar_lis = $('.treeview-menu').find('li');
    for(var int_i=0;int_i<leftbar_lis.length;int_i++){
        if(leftbar_lis[int_i]==obj){
            $(leftbar_lis[int_i]).addClass('active');
        }else{
            $(leftbar_lis[int_i]).removeClass('active')
		}
    }
}

function tusi(txt,fun){
	$('.tusi').remove();
	var div = $('<div style="width:100%;position: absolute;left: -10rem;top: -10rem;text-align: center;"><span style="color: #ffffff;padding:4px 14px;background: rgba(0,0,0,0.6);border-radius: .1rem; font-size: 14px;">'+txt+'</span></div>');
	$('body').append(div);
	div.css('zIndex',9999999);
	div.css('left',parseInt(($(window).width()-div.width())/2));
	var top = parseInt($(window).scrollTop()+($(window).height()-div.height())/2);
	div.css('top',top);
	setTimeout(function(){
		div.remove();
    	if(fun){
    		fun();
    	}
	},2000);
}

function loading(txt){
	if(txt === false){
		$('.qp_lodediv').remove();
	}else{
		$('.qp_lodediv').remove();
		var div = $('<div class="qp_lodediv" style="min-width: .8rem;height: .8rem;padding: 0 6px;border-radius: .1rem; box-sizing: border-box; position: absolute;left: -10rem;top: -10rem;text-align: center;background: rgba(0,0,0,0.6);font-size: 12px;overflow: hidden;zoom: 1;"><div style="display: inline-block; width: .6rem;height: .6rem;margin-top: .1rem;"> <img src="'+imagespath+'/load.gif" width="100%"/></div><span style="font-size: 14px;color: #fff;vertical-align: 52%"> '+txt+'</span></div>');
		$('body').append(div);
		div.css('zIndex',9999999);
		div.css('left',parseInt(($(window).width()-div.width())/2));
		var top = parseInt($(window).scrollTop()+($(window).height()-div.height())/2);
		div.css('top',top);
	}	
}

function checkMobile(s){
	var regu =/^[1][3|8|4|5|7|9][0-9]{9}$/;
	var re = new RegExp(regu);
	if (re.test(s)) {
		return true;
	}else{
		return false;
	}
}

function checkIdCard(s){
    var regu =/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/;
    var re = new RegExp(regu);
    if (re.test(s)) {
        return true;
    }else{
        return false;
    }
}

function checkLandline(s) {
	var regex = /^0\d{2,3}-?\d{7,8}$/;
	var re = new RegExp(regex);
	if (re.test(s)) {
		return true;
	} else {
		return false;
	}
}

function checkDocForm () {
    if($('#phone').val()){
        if(!/^1[3|4|5|7|8]\d{9}$/.test($('#phone').val())){
            alert('手机号码格式错误'); return false;
        }
    }
    for (var i=0;i<$('.edit-avail').length;i++) {
        if ($($('.edit-avail')[i]).html() != '') {
            $('#table-form').append("<input type='hidden' name='"+$($('.edit-avail')[i]).data('n')+"' value='1'/>");
        } else {
            $('#table-form').append("<input type='hidden' name='"+$($('.edit-avail')[i]).data('n')+"' value='0'/>");
        }
    }
}

function checkFdDocForm () {
    for (var i=0;i<$('.edit-avail').length;i++) {
        if ($($('.edit-avail')[i]).html() != '') {
            $('#table-form').append("<input type='hidden' name='"+$($('.edit-avail')[i]).data('n')+"' value='1'/>");
        } else {
            $('#table-form').append("<input type='hidden' name='"+$($('.edit-avail')[i]).data('n')+"' value='0'/>");
        }
    }
}
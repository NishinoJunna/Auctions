$(function(){
	$('#bidding').on('click',bidRequest);
});

function bidRequest(event){
	adminOrderEditFormInit();
	$('#loading').fadeIn();
	var data = $('#bidadd').serialize();
	console.log(data);
	$.ajax({
		url: "/Auctions/admin/bids/getmaxajax",
		type: "POST",
		data: data,
		dataType: "json",
		success: successAction,
		error: errorMessage,
	});
	
}

function adminOrderEditFormInit(){
	$('#message').remove();
	$('.help-block').remove();
	$('.form-group').removeClass('has-error');
}

function successAction(result){
	$('#loading').fadeOut();
	if(result['status']=='success'){
		showSuccessMessage('入札しました');
		$('#max_v').html($("#bid_v").val());
		$('#history').html("");
		for(var key in result['bid']){
			$('#history').append(
								"<tr><td>"+result['user_id'][key]+"</td><td>"+
								result['bid'][key]+"</td><td>"+
								result['created'][key]+"</td></tr>");
		}
		$('#history').prepend("<tr id=\"historytr\"><th scope=\"col\">ユーザID</th><th scope=\"col\">入札額</th><th scope=\"col\">日時</th></tr>");
		console.log(result['created']);
	}else if(result['status']=='less'){
		if($('#max_v').html()<$("#bid_v").val()){
			showErrorMessage('最高額が更新されました');
		}else{
			showErrorMessage('現在価格より多い額で入札できます');
		}
			showValidationMessage(result['errors']);
		$('#max_v').html(result['max']);
		$('#history').html("");
		for(var key in result['bid']){
			$('#history').append(
								"<tr><td>"+result['user_id'][key]+"</td><td>"+
								result['bid'][key]+"</td><td>"+
								result['created'][key]+"</td></tr>");
		}
		$('#history').prepend("<tr id=\"historytr\"><th scope=\"col\">ユーザID</th><th scope=\"col\">入札額</th><th scope=\"col\">日時</th></tr>");
	}else if(result["status"]=="ownproduct"){
		showErrorMessage('自分の商品には入札できません');//Homeでやる？
	}else{
		showErrorMessage('入札に失敗しました');
		showValidationMessage(result['errors']);
	}
	
}

function errorMessage(){
	console.log("失敗");
}

function showSuccessMessage(message){
	var tag = '<div id="message" class="alert alert-success">';
	tag += message;
	tag += '</div>';
	$('.main').prepend(tag);
}

function showErrorMessage(message){
	var tag = '<div id="message" class="alert alert-danger">';
	tag += message;
	tag +='</div>';
	$('.main').prepend(tag);
}

function showValidationMessage(errors){
	for( key in errors ){
		var obj = $("[name=']" + key + "']");
		obj.parent().addClass('has-error');
		var field = errors[key];
		for( var value in field ){
			var tag = '<div class="help-block">' + field[value] + '</div>';
			obj.after(tag);
		}
	}
}




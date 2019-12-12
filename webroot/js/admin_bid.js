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
		$('a.max_v').html($("#bid_v").val());
	}else if(result['status']=='less'){
		showErrorMessage('現在価格より多い額で入札できます');
		if($('a.max_v').html()>bidding){
			showErrorMessage('最高額が更新されました');
		}
		showValidationMessage(result['errors']);
		$('a.max_v').html(maxs);
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




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

function successAction(){
	$('#loading').fadeOut();
	if(result['status']=='success'){
		showSuccessMessage('受注を更新しました');
	}else{
		showErrorMessage('登録に失敗しました');
		showValidationMessage(result['errors']);
	}
	$('a.max_v').html(data['bid']);
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




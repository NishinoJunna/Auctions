$(function(){
	$('#bidding').on('click',bidRequest);
});

function bidRequest(bid){
	getMax(max);
	var data = $("#bidadd").serialize();
	$.ajax({
		url: "/Auctions/admin/bids/getMaxAjax",
		type: "post",
		data: data,
		dataType: "json",
		success: successMessage,
		error: errorMessage,
	});
}

function successMessage(result){
	console.log(result);
}

function errorMessage(result){
	console.log(result);
}

function getMax(max){
	var nowmax = ("a.max_v").html();
	if(nowmax > max){
		console.log("最高額が更新されました");
	}else{
		console.log("入札できます");
	}
}

<?php $this->prepend('script',$this->Html->script('admin_bid')); ?>

,["type"=>"button","id"=>"bidding"]
<h1 class="page-header">商品編集</h1>
<?php
	echo $this->Form->create($product);
	if(empty($activBid)){
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('start_price');
		if(empty($startBid)){
			echo $this->Form->input('start_date',['type'=>'datetime', 'minYear'=>date('Y'), 'interval'=> 15 ]);
		}
	}
	echo $this->Form->input('end_date',['type'=>'datetime', 'minYear'=>date('Y'), 'interval'=> 15 ]);
	echo $this->Form->button("登録");
	echo $this->Form->end();
?>
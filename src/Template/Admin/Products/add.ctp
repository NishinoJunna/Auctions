<h1 class="page-header">商品新規登録</h1>
<?php
	echo $this->Form->create($product);
	echo $this->Form->input('name');
	echo $this->Form->input('description');
	echo $this->Form->input('start_price');
	echo $this->Form->input('start_date',['type'=>'datetime', 'minYear'=>date('Y'), 'interval'=> 15 ]);
	echo $this->Form->input('end_date',['type'=>'datetime']);
	echo $this->Form->button("登録");
	echo $this->Form->end();
?>
<?php $this->prepend('script',$this->Html->script('admin_bid')); ?>
<h1 class="page-header">入札する</h1>
<?php
	echo $this->Form->create($bid);
	echo "商品名：".h($product->name);
	echo "</br>";
	echo "現在価格：".h($max);
	echo $this->Form->input('bid');
	echo $this->Form->button("入札する",["type"=>"button","id"=>"bidding"]);
	echo $this->Form->end();
?>
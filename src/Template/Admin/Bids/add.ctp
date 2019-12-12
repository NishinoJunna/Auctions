
<h1 class="page-header">入札する</h1>
<?php
	echo $this->Form->create($bid,["id"=>"bidadd"]);
	echo "商品名：".h($product->name);
	echo "</br>";
	echo "現在価格：<a class=\"max_v\">".h($max)."</a>";
	echo $this->Form->input('bid');
	echo $this->Form->button("入札する");
	echo $this->Form->end();
?>
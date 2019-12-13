<?php $this->prepend('script',$this->Html->script('admin_bid')); ?>

<h1 class="page-header">入札する</h1>
<?php
	echo $this->Form->create($bid,["id"=>"bidadd",]);
	echo "商品名：".h($product->name);
	echo "</br>";
	echo "現在価格：<a id=\"max_v\">".h($max)."</a>";
	echo $this->Form->input('bid',['label' => false,"id"=>"bid_v"]);
	echo $this->Form->input('product_id',['value'=>$product['id'],'type'=>'hidden']);
	echo $this->Form->button("入札する",["type"=>"button","id"=>"bidding"]);
	echo $this->Form->end();
?>

<h1 class"page-header">入札履歴</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0" id="history">
<tr>
	<th scope="col">ユーザID</th>
	<th scope="col">入札額</th>
	<th scope="col">日時</th>
</tr>
<?php if(isset($histories)): ?>
<?php foreach ($histories as $b): ?>
	<tr>
		<td><?= $this->Number->format($b->user_id)  ?></td>
		<td><?= $this->Number->format($b->bid)  ?></td>
		<td><?= h($b->created->format("Y年m月d日h時i分")) ?></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</table>
<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->numbers([
			'before'	=>	$this->Paginator->first("<<"),
			'after'		=>	$this->Paginator->last(">>"),
		]) ?>
	</ul>
</div>
<?php $this->prepend('script',$this->Html->script('admin_bid')); ?>

<h1><?php echo h($product->name); ?></h1>
<div id="left">
	<?php  echo $this->Html->image($product->image, array('width'=>"400")); ?>
</div>
<div id="right">
	<p id="max_v" style="font-size:30px;">現在価格：<?php echo $this->Number->format($max); ?>円</p>
	<p style="font-size:20px;">終了時刻：<?php echo h($product->end_date->format("Y年m月d日 　G時i分"));?></p>
<?php
	echo $this->Form->create($bid,["id"=>"bidadd",]);
	echo $this->Form->input('bid',['label' => false,"id"=>"bid_v"]);
	echo $this->Form->input('product_id',['value'=>$product['id'],'type'=>'hidden']); ?>
	<button type="button" id="bidding" class="bid_button">入札する</button>
<?php	echo $this->Form->end();
?>
</div>
<div style="clear:both;"></div>
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
		<td><?= h($b->user->email)  ?></td>
		<td>¥<?= $this->Number->format($b->bid)  ?></td>
		<td><?= h($b->created->format("Y年m月d日H時i分")) ?></td>
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
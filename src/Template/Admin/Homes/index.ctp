<h1 class"page-header">オークション開催中の商品一覧</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?=$this->Paginator->sort('id','ID') ?></th>
	<th scope="col"><?=$this->Paginator->sort('name','商品名') ?></th>
	<th scope="col"><?=$this->Paginator->sort('description','商品説明') ?></th>
	<th scope="col">現在入札した人数</th>
	<th scope="col"><?=$this->Paginator->sort('start_price','開始金額') ?></th>
	<th scope="col">現在価格</th>
	<th scope="col"><?=$this->Paginator->sort('start_date','開始日時') ?></th>
	<th scope="col"><?=$this->Paginator->sort('end_date','終了日時') ?></th>
	<th scope="col">操作</th>
</tr>
<?php foreach ($products as $product): ?>
	<tr>
		<td><?= $this->Number->format($product->id)  ?></td>
		<td><?= h($product->name) ?></td>
		<td><?= h($product->description) ?></td>
		<td></td>
		<td><?= $this->Number->format($product->start_price)  ?></td>
		<td></td>
		<td><?= h($product->start_date->format("Y年m月d日h時i分")) ?></td>
		<td><?= h($product->end_date->format("Y年m月d日h時i分")) ?></td>
		<td><?= $this->Html->link("入札",["controller" => "Bids", "action" => "add",$product->id]) ?></td>
	</tr>
<?php endforeach; ?>
</table>
<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->numbers([
			'before'	=>	$this->Paginator->first("<<"),
			'after'		=>	$this->Paginator->last(">>"),
		]) ?>
	</ul>
</div>
<h1 class"page-header">オークション終了した商品一覧</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?=$this->Paginator->sort('id','ID') ?></th>
	<th scope="col"><?=$this->Paginator->sort('name','商品名') ?></th>
	<th scope="col"><?=$this->Paginator->sort('description','商品説明') ?></th>
	<th scope="col"><?=$this->Paginator->sort('end_date','終了日時') ?></th>
	<th scope="col">操作</th>
</tr>
<?php if(isset($products)): ?>
<?php foreach ($products as $product): ?>
	<tr>
		<td><?= $this->Number->format($product->id)  ?></td>
		<td><?= h($product->name) ?></td>
		<td><?= h($product->description) ?></td>
		<td><?= h($product->end_date->format("Y年m月d日h時i分")) ?></td>
		<td>
			<?= $this->Html->link("入札状況",["action" => "indexOff",$product->id]) ?>
		</td>
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
<p><?=$user["email"]; ?>さんの</p>
<h2 class="header">オークション開催中の商品</h2>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col">ID</th>
	<th scope="col">商品名</th>
	<th scope="col">商品説明</th>
	<th scope="col">終了日時</th>
	<th scope="col">操作</th>
</tr>
<?php if(isset($products)): ?>
<?php foreach ($products as $product): ?>
	<tr>
		<td><?= $this->Number->format($product->id)  ?></td>
		<td><?= h($product->name) ?></td>
		<td><?= h($product->description) ?></td>
		<td><?= h($product->end_date->format("Y年m月d日H時i分")) ?></td>
		<td>
			<?= $this->Html->link("入札状況",["action" => "indexOn",$product->id]) ?>
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
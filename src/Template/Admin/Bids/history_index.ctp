<h1 class"page-header">入札履歴</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?=$this->Paginator->sort('product_id','商品ID') ?></th>
	<th scope="col"><?=$this->Paginator->sort('product.name','商品名') ?></th>
	<th scope="col"><?=$this->Paginator->sort('bid','入札額') ?></th>
	<th scope="col"><?=$this->Paginator->sort('created','日時') ?></th>
</tr>
<?php if(isset($bids)): ?>
<?php foreach ($bids as $b): ?>
	<tr>
		<td><?= $this->Number->format($b->product_id)  ?></td>
		<td><?= h($b->product->name) ?></td>
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

<h1 class"page-header">落札商品</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col">商品名</th>
	<th scope="col">説明</th>
	<th scope="col">ユーザ名</th>
	<th scope="col">落札額</th>
</tr>
<?php if(isset($endbids)): ?>
<?php foreach ($endbids as $endbid): ?>
	<tr>
		<td><?= $this->Number->format($endbid->name)  ?></td>
		<td><?= h($endbid->description) ?></td>
		<td><?=h($endbid->user_name) ?></td>
		<td><?= $this->Number->format($endbid->bid)  ?></td>
	</tr>
<?php endforeach; ?>
<?php endif; ?>
</table>
<h2><?=h($product->name) ?>　の入札状況</h2>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?=$this->Paginator->sort('user.email','ユーザ名') ?></th>
	<th scope="col"><?=$this->Paginator->sort('bid','入札額') ?></th>
	<th scope="col"><?=$this->Paginator->sort('created','日時') ?></th>
</tr>
<?php if(isset($bids)): ?>
<?php foreach ($bids as $b): ?>
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
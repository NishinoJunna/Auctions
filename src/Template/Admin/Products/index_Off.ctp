<h1 class"page-header">入札状況</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?=$this->Paginator->sort('user.email','ユーザ名') ?></th>
	<th scope="col"><?=$this->Paginator->sort('bid','入札額') ?></th>
	<th scope="col"><?=$this->Paginator->sort('created','日時') ?></th>
	<th></th>
</tr>
<?php if(isset($bids)): 
	$count = 0; ?>
<?php foreach ($bids as $b):
	if($b->bid == $maxbid):?>
	<tr style="background-color:#FFFF66">
		<td><?= h($b->user->email)  ?></td>
		<td><?= $this->Number->format($b->bid)  ?></td>
		<td><?= h($b->created->format("Y年m月d日h時i分")) ?></td>
		<td>落札</td>
	</tr>
	<?php else: ?>
	<tr>
		<td><?= h($b->user->email)  ?></td>
		<td><?= $this->Number->format($b->bid)  ?></td>
		<td><?= h($b->created->format("Y年m月d日h時i分")) ?></td>
		<td></td>
	</tr>
	<?php endif; ?>	
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
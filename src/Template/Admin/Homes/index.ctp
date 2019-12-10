<h1 class"page-header">イベント一覧</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?=$this->Paginator->sort('id','ID') ?></th>
	<th scope="col"><?=$this->Paginator->sort('name','イベント名') ?></th>
	<th scope="col"><?=$this->Paginator->sort('max_participant','最大の参加者数') ?></th>
	<th scope="col">現在の参加者数</th>
	<th scope="col"><?=$this->Paginator->sort('categorie.name','カテゴリ') ?></th>
	<th scope="col"><?=$this->Paginator->sort('user.email','管理ユーザ') ?></th>
	<th scope="col"><?=$this->Paginator->sort('modified','最終更新日時') ?></th>
	<th scope="col">操作</th>
</tr>
<?php foreach ($events as $event): ?>
	<tr>
		<td><?= $this->Number->format($event->id)  ?></td>
		<td><?= h($event->name) ?></td>
		<td><?= $this->Number->format($event->max_participant)  ?></td>
		<td><?= $this->Number->format(count($event->event_users)) ?></td>
		<td><?= h($event->category->name) ?></td>
		<td><?= h($event->user->email) ?></td>
		<td><?= h($event->modified->format("Y年m月d日h時i分")) ?></td>
		<td><?= $this->Html->link("表示",["controller" => "Events", "action" => "view",$event->id]) ?></td>
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
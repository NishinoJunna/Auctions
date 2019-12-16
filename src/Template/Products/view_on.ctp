<h1 class="page-header">出品商品の個別</h1>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th>id</th>
	<th>商品名</th>
	<th>商品説明</th>
	<th>終了日時</th>
	<th>最終更新日時</th>
</tr>
	<tr>
		<td><?= $product->id  ?></td>
		<td><?= $product->name ?></td>
		<td><?= $product->description ?></td>
		<td><?= $product->end_date->format("Y年m月d日h時i分") ?></td>
		<td><?= $product->modified->format("Y年m月d日h時i分") ?></td>
	</tr>
</table>

<div class="panel panel-primary">
  <div class="panel-heading">現在価格</div>
  <div class="panel-body">
    <?= $maxbid . "円"?>
  </div>
</div>

<?php echo $this->Html->image($product->image, array('width'=>"400", "height"=>"300")); ?>
<div id="login"><?php echo $this->Html->link(
	    'ログイン',
	    array('controller' => 'Users', 'action' => 'login'),
	    array('class' => 'btn btn-primary', 'role' => 'button')
	); ?> </div>

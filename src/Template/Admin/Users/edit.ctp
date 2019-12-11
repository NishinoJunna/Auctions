<h1 class="page-header">パスワード変更</h1>
<?php
	echo $this->Form->create($user);
?>
<table class="table table-striped" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?php echo "ユーザID"; ?></th>
	<td><?= h($user->email) ?></td>
</tr>
<tr>
	<th scope="col"><?php echo "パスワード"; ?></th>
	<td><?php echo $this->Form->input('password'); ?></td>
</tr>
</table>
<?php
echo $this->Form->button("登録");
echo $this->Form->end();
?>

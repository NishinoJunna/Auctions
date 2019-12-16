<h1 class="page-header">パスワード変更</h1>
<?php
	echo $this->Form->create($user);
?>
<table class="password" cellpadding="0" cellspacing="0">
<tr>
	<th scope="col"><?php echo "ユーザID"; ?></th>
	<td><?= h($user->email) ?></td>
</tr>
<tr>
	<th scope="col"><?php echo "パスワード"; ?></th>
	<td><input type="password" name="password" style="width:220px; height:35px; margin:0 auto;" required="required" id="password" class="form-control"></td>
</tr>
</table>
<?php
echo $this->Form->button("変更",["class"=>"register"]);
echo $this->Form->end();
?>

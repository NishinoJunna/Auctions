<h1 class="page-header">ユーザ登録</h1>
<?php
echo $this->Form->create($user);
echo $this->Form->input('email');
echo $this->Form->input('password');
echo $this->Form->button("登録",["style"=>"width:82px;"]);
echo $this->Form->end();
?>
<h1 class="page-header">入札する</h1>
<?php
	echo $this->Form->create($bid);
	echo h($this->product->name);
	echo h($this->product->max);
	echo $this->Form->input('bid');
	echo $this->Form->button("入札する");
	echo $this->Form->end();
?>
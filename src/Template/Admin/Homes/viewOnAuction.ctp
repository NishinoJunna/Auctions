<div class="row">
	<div class="col-md-5">
		<div class="list-group">
		<?php
		foreach($homeMenus as $text => $link):
			echo $this->Html->link($text,$link,["class"=>"list-group-item"]);
		endforeach;
		?>
		</div>
	</div>
</div>

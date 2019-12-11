<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<?=$this->Html->link("No1 Auctions Site","/" ,["class"=>"navbar-brand"]); ?>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
				<?=$this->Html->link("ログイン","/users/login"); ?>
				</li>
				<li class="dropdown">
				<?=$this->Html->link("ユーザ登録","/users/register"); ?>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<?=$this->Html->link("No1 Auctions Site",["controller"=>"Homes"],["class"=>"navbar-brand"]); ?>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<?=$this->Html->link("商品管理","#",["data-toggle"=>"dropdown"]);?>
					<ul class="dropdown-menu">
						<li><?=$this->Html->link("一覧","/admin/products/index");?></li>
						<li><?=$this->Html->link("新規追加","/admin/products/add");?></li>
					</ul>
				</li>
				<li class="dropdown">
					<?=$this->Html->link("入札管理","#",["data-toggle"=>"dropdown"]);?>
					<ul class="dropdown-menu">
						<li><?=$this->Html->link("オークション開催中商品一覧","/admin/products/viewOn");?></li>
						<li><?=$this->Html->link("オークションが終了した商品一覧","/admin/products/viewOff");?></li>
						<li><?=$this->Html->link("オークション開催中商品入札状況一覧","/admin/products/indexOn");?></li>
						<li><?=$this->Html->link("オークションが終了した商品入札状況一覧","/admin/products/indexOff");?></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
					<p class="navbar-text">ようこそ, <?=$auth["email"]; ?></p>
					<li class="dropdown">
						<?=$this->Html->link("管理","#",["data-toggle"=>"dropdown"]);?>
						<ul class="dropdown-menu">
							<li><?=$this->Html->link("入札履歴","/admin/bids/history_index")?></li>
							<li><?=$this->Html->link("ユーザ編集","/admin/users/edit")?></li>
							<li><?=$this->Html->link("ログアウト","/admin/users/logout")?></li>
						</ul>
					</li>
			</ul>
		</div>
	</div>
</div>

























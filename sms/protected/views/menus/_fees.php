	<div class="row __mobile">
		<span class="placeholder">Secondary Menu <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
		<button class="__nav-icon __nav-icon-x">
		  <span>Menu</span>
		</button>
	</div>
	<div class="secondary-menu">
		<ul>
			<li><a href="<?= SITE_URL.'fees/' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Dashboard</a></li>
			<li><a href="<?= SITE_URL.'fees/processfees' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Process Fees</a></li>
			<li><a href="<?= SITE_URL.'fees/paidfees' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Fee History</a></li>
			<li class="right"><a href="<?= SITE_URL.'logout' ?>"><?= (isset($logo) && $logo != '') ? '<img src="'.SITE_URL.$logo.'" class="img_logo">' : '<i class="fa fa-user-circle" aria-hidden="true"></i>' ?> Logout</a></li>
		</ul>
	</div>



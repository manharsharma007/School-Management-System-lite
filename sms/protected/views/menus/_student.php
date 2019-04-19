	<div class="row __mobile">
		<span class="placeholder">Secondary Menu <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
		<button class="__nav-icon __nav-icon-x">
		  <span>Menu</span>
		</button>
	</div>
	<div class="secondary-menu">
		<ul>
			<li><a href="<?= SITE_URL.'students/' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Users Dashboard</a></li>
			<li><a href="<?= SITE_URL.'students/addstudent' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Add Student</a></li>
			<li><a href="<?= SITE_URL.'students/addclass' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Add Class</a></li>
			<li><a href="<?= SITE_URL.'students/promotestudent' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Promote Student</a></li>
			<li><a href="<?= SITE_URL.'students/viewstudent' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> View Student</a></li>
			<li><a href="<?= SITE_URL.'students/leftstudent' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Left Student</a></li>
			<li class="right"><a href="<?= SITE_URL.'logout' ?>"><?= (isset($logo) && $logo != '') ? '<img src="'.SITE_URL.$logo.'" class="img_logo">' : '<i class="fa fa-user-circle" aria-hidden="true"></i>' ?> Logout</a></li>
		</ul>
	</div>



	<div class="row __mobile">
		<span class="placeholder">Secondary Menu <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
		<button class="__nav-icon __nav-icon-x">
		  <span>Menu</span>
		</button>
	</div>
	<div class="secondary-menu">
		<ul>
			<li><a href="#" class="popup-link" data-href="modal_username"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Change Username</a></li>
			<li><a href="#" class="popup-link" data-href="modal_manually"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Change Password</a></li>
			<li class="right"><a href="<?= SITE_URL.'logout' ?>"><?= (isset($logo) && $logo != '') ? '<img src="'.SITE_URL.$logo.'" class="img_logo">' : '<i class="fa fa-user-circle" aria-hidden="true"></i>' ?> Logout</a></li>
		</ul>
	</div>
	<div class="popup-container" id="modal_manually">
		<div class="popup-window popup-window-small">
			<div class="popup-header"><i class="fa fa-pencil"></i> Please fill details<a href="#" class="popup-close right" data-href="modal"><i class="fa fa-times" aria-hidden="true"></i></a></div>
			<div class="popup-content">
		
						<form action="#" data-action="<?= SITE_URL ?>/home/changepassword" class="clearfix form form_ajax" method="post">
						
						<div class="row ajax_response"></div>
						<div class="form-body">
							<div class="input-element-half">
								<label for="email">Email <sup>*</sup></label>
								<input type="email" id="email" name="email">
							</div>
							<div class="input-element-half">
								<label for="old">Old Password <sup>*</sup></label>
								<input type="password" id="old" name="old">
							</div>
							<div class="row">
							    <div class="input-element-half">
									<label for="new">New Password <sup>*</sup></label>
									<input type="password" id="new" name="new">
								</div>
								<div class="input-element-half">
									<label for="confirm">Confirm password <sup>*</sup></label>
									<input type="password" id="confirm" name="confirm">
								</div>
							</div>					

							<button type="submit" class="button send">Submit</button>
						</div>
					</form>
			</div>
		</div>
	</div>

	<div class="popup-container" id="modal_username">
		<div class="popup-window popup-window-small">
			<div class="popup-header"><i class="fa fa-pencil"></i> Please fill details<a href="#" class="popup-close right" data-href="modal"><i class="fa fa-times" aria-hidden="true"></i></a></div>
			<div class="popup-content">
		
						<form action="#" data-action="<?= SITE_URL ?>/home/changeusername" class="clearfix form form_ajax" method="post">
						
						<div class="row ajax_response"></div>
						<div class="form-body">
							<div class="input-element">
								<label>Email <sup>*</sup></label>
								<input type="email" id="uemail" name="email">
							</div>
							<div class="input-element-half">
								<label for="old">Old Username <sup>*</sup></label>
								<input type="password" id="uold" name="old">
							</div>
						     <div class="input-element-half">
								<label for="name">New Username <sup>*</sup></label>
								<input type="password" id="unew" name="new">
							</div>		

							<button type="submit" class="button send">Submit</button>
						</div>
					</form>
			</div>
		</div>
	</div>

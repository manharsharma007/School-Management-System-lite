	<div class="row __mobile">
		<span class="placeholder">Secondary Menu <i class="fa fa-angle-double-right" aria-hidden="true"></i></span>
		<button class="__nav-icon __nav-icon-x">
		  <span>Menu</span>
		</button>
	</div>
	<div class="secondary-menu">
		<ul>
			<li><a href="<?= SITE_URL.'notifications/' ?>"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> Notify Users</a></li>
			<li class="right"><a href="<?= SITE_URL.'logout' ?>"><?= (isset($logo) && $logo != '') ? '<img src="'.SITE_URL.$logo.'" class="img_logo">' : '<i class="fa fa-user-circle" aria-hidden="true"></i>' ?> Logout</a></li>
		</ul>
	</div>



					<div class="popup-container" id="modal_manually">
						<div class="popup-window-small popup-window">
							<div class="popup-header"><i class="fa fa-envelope"></i> Send Message<a href="#" class="popup-close right" data-href="modal"><i class="fa fa-times" aria-hidden="true"></i></a></div>
							<div class="popup-content">
						
										<form action="#" data-action="<?= SITE_URL ?>/notifications/notify" id="form" class="clearfix form form_ajax" method="post">
										
										<div class="row ajax_response"></div>
										<div class="form-body">
											<div class="input-element">
												<label for="name">Message</label>
												<textarea name="message"></textarea>
											</div>								

											<button type="submit" class="button send">Submit</button>
										</div>
									</form>
							</div>
						</div>
					</div>

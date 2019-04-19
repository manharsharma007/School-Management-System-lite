				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_index.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>SETTINGS</h4>
					</div>
					<form action="" method="post" enctype="multipart/form-data">
					
					<div class="form">
						<div class="form-header">
							<p><i class="fa fa-pencil"></i> Please fill the setting form</p>
						</div>
						
						<div class="form-body">
							<?php
		if(isset($error['error_code']) && isset($error['message'])) {

			if($error['error_code'] == SUCCESS)
				echo '<div class="msg success"><p>'.$error["message"].'</p>';
			elseif($error['error_code'] == WARNING)
				echo '<div class="msg warning"><p>'.$error["message"].'</p>';
			elseif($error['error_code'] == ERROR)
				echo '<div class="msg fail"><p>'.$error["message"].'</p>';

			echo'</div>';
		}

	?>
	
											<input type="hidden" name="security_token" value = "<?= $token ?>"/>
							<div class="input-element">
								<label for="name">Institute name <sup>*</sup></label>
								<input type="text" id="name" name="school_name" value="<?= (isset($settings[0]->institute_name)) ? $settings[0]->institute_name : '' ; ?>">
							</div>
							<div class="input-element">
								<label for="name">Institute Code <sup>*</sup></label>
								<input type="text" id="name" name="school_code" value="<?= (isset($settings[0]->school_code)) ? $settings[0]->school_code : '' ; ?>">
							</div>
							<div class="input-element">
								<label for="name">Email <sup>*</sup></label>
								<input type="text" id="name" name="email" value="<?= (isset($settings[0]->email)) ? $settings[0]->email : '' ; ?>">
							</div>
							<div class="input-element">
								<label for="name">Phone <sup>*</sup></label>
								<input type="text" id="name" name="phone" value="<?= (isset($settings[0]->phone)) ? $settings[0]->phone : '' ; ?>">
							</div>
							<div class="input-element">
								<label for="name">Address <sup>*</sup></label>
								<textarea id="" rows="60" name="address"><?= (isset($settings[0]->address)) ? $settings[0]->address : '' ; ?></textarea>
							</div>
							<div class="input-item file-display __text-left"><?= (isset($settings[0]->logo) && $settings[0]->logo != '') ? '<img src="'.SITE_URL.$settings[0]->logo.'" width="200">' : '' ; ?></div>
							<div class="upload-item">
								<label for="">Logo</label>
								<input type="file" id="file" name="files" value="" class="file file-upload">
								<label class="title" for="file"><i class="fa fa-paperclip" aria-hidden="true"></i> Select Logo</label>							
							</div>

							<fieldset>
								<legend>Current Session</legend>

								<div class="input-element-half">
									<label for="from_period">From <sup>*</sup></label>
									<input type="text" id="from_period" name="from_period" class="datepicker" autocomplete="off" value="<?= (isset($settings[0]->from_period)) ? $settings[0]->from_period : '' ; ?>">
								</div>

								<div class="input-element-half">
									<label for="to_period">to_period <sup>*</sup></label>
									<input type="text" id="to_period" name="to_period" class="datepicker" autocomplete="off" value="<?= (isset($settings[0]->to_period)) ? $settings[0]->to_period : '' ; ?>">
								</div>

							</fieldset>

							<button type="submit" class="button send" name="submit">Submit</button>
						</div>

					</div>
</form>

</div>
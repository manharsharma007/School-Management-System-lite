<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_student.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>ADD Class</h4>
					</div>
<form action="" method="post" enctype="multipart/form-data">
					<div class="form">
						<div class="form-header">
							<p><i class="fa fa-pencil"></i>Please fill the Class details</p>
						</div>

						<?php
		if(isset($error['error_code']) && isset($error['message'])) {

			if($error['error_code'] == SUCCESS)
				echo '<div class="msg success"><p>'.$error["message"].'</p></div>';
			elseif($error['error_code'] == WARNING)
				echo '<div class="msg warning"><p>'.$error["message"].'</p></div>';
			elseif($error['error_code'] == ERROR)
				echo '<div class="msg fail"><p>'.$error["message"].'</p></div>';

		}

	?><input type="hidden" name="security_token" value = "<?= $token ?>"/>
							
											<div class="input-element">
												<label for="class">Class Name <sup>*</sup></label>
												<input type="text" id="class" name="class_name" value="<?php if(isset($class_name)) echo $class_name ?>">
											</div>
										     <div class="input-element">
												<label for="fees">Fees <sup>*</sup></label>
												<input type="text" id="fees" name="fees" value="<?php if(isset($fees)) echo $fees ?>">
											</div>
										     <div class="input-element">
												<label for="exclusion_months">Exclusion Months (Use Ctrl)</label>
												<select name="exclusion_months[]" id="exclusion_months" multiple>
													<?php
														$month = array('Jan','Feb','March','April','May','June','July','Aug','Sep','Oct','Nov','Dec');
														for($i = 1; $i < 13; $i++)
														{
															?>
															<option value="<?php echo $i ?>"><?php echo $month[$i - 1] ?></option>
															<?php
														}
													?>
												</select>
											</div>											

											<button type="submit" class="button send" name="submit">Submit</button>
						
						</div>
</form>
					</div>
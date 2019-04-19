<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_attendance.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>DELETE ATTENDANCE</h4>
					</div>
<form action="" method="post" enctype="multipart/form-data" autocomplete="off">

						<?php
		if(isset($error['error_code']) && isset($error['message'])) {

			if($error['error_code'] == SUCCESS)
				echo '<div class="msg success"><p>'.$error["message"].'</p></div>';
			elseif($error['error_code'] == WARNING)
				echo '<div class="msg warning"><p>'.$error["message"].'</p></div>';
			elseif($error['error_code'] == ERROR)
				echo '<div class="msg fail"><p>'.$error["message"].'</p></div>';

		}

	?>
					<div class="form">
						<div class="form-header">
							<p><i class="fa fa-pencil"></i>Please Select Class details</p>
						</div>					

										<input type="hidden" name="security_token" value = "<?= $token ?>"/>	
											<div class="input-element">
												<label for="class">Class Name <sup>*</sup></label>
												<select name="class" id="class">
													<option>Select Class....</option>
												<?php
													if(isset($class))
													foreach ($class as $key => $value) {
														echo '<option  value="'.$value->class_id.'">'.$value->class_name.'</option>';
													}
												?>
												</select>
											</div>

											<div class="input-element">
												<label for="class">From Date <sup>*</sup></label>
												<input type="text" name="fromdate" value="" class="datepicker">
											</div>

											<div class="input-element">
												<label for="class">To Date <sup>*</sup></label>
												<input type="text" name="todate" value="" class="datepicker">
											</div>

											<button type="submit" class="button send" name="submit">Submit</button>
						</div>
						
</form>
					</div>
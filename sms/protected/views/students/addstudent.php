				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_student.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>STUDENT DETAILS</h4>
					</div>
<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
					<div class="form">
						<div class="form-header">
							<p><i class="fa fa-pencil"></i>Please fill the Student's details</p>
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

	?>
							<input type="hidden" name="security_token" value = "<?= $token ?>"/>
											<div class="input-element-half">
												<label for="student_name">Student Name <sup>*</sup></label>
												<input type="text" id="student_name" name="student_name" value="<?php if(isset($student_name)) echo $student_name ?>">
											</div>
										     <div class="input-element-half">
												<label for="dob">DOB <sup>*</sup></label>
												<input type="text" id="dob" name="dob" value="<?php if(isset($dob)) echo $dob ?>" class="datepicker">
											</div>
											<div class="input-element-half">
												<label for="lang">Mother Tongue <sup>*</sup></label>
												<input type="text" id="lang" name="lang" value="<?php if(isset($lang)) echo $lang ?>">
											</div>
											<div class="input-element-half">
												<label for="religion">Religion</label>
												<input type="text" id="religion" name="religion" value="<?php if(isset($religion)) echo $religion ?>">
											</div>

											<div class="input-element">
												<label for="address">Address</label>
												<textarea id="address" name="address"><?php if(isset($address)) echo $address ?></textarea>
											</div>
											
											<div class="input-element">
												<label for="class">Class <sup>*</sup></label>
												<select name="class" id="class">
												<?php
													if(isset($class))
													foreach ($class as $key => $value) {
														echo '<option  value="'.$value->class_id.'">'.$value->class_name.'</option>';
													}
												?>
												</select>
											</div>
											
											<div class="input-element-half">
												<label for="student_status">Status <sup>*</sup></label>
												<select name="student_status" id="student_status">
													<option value="STUDYING">STUDYING</option>
													<option value="TRANSFERRED">TRANSFERRED</option>
													<option value="LEFT">LEFT</option>
												</select>
											</div>

											<div class="input-element-half">
												<label for="roll_no">Roll number <sup>*</sup></label>
												<input type="text" id="roll_no" name="roll_no" value="<?= isset($roll) ? $roll : '' ; ?>">
											</div>
											<div class="input-element-half">
												<label for="reg_no">Registration number <sup>*</sup></label>
												<input type="text" id="reg_no" name="reg_no" value="<?= isset($reg_no) ? $reg_no : '' ; ?>">
											</div>

															
											<div class="input-element-half">
												<label for="srn">SRN <sup>*</sup></label>
												<input type="text" id="srn" name="srn" value="<?= isset($srn) ? $srn : '' ; ?>">
											</div>
											
											<fieldset>
												<legend>Fee Details</legend>
												<div class="row">
												<div class="input-element-half">
													<label for="fee_mode">Mode <sup>*</sup></label>
													<select name="fee_mode" id="fee_mode">
														<option value="ANNUALLY">ANNUALLY</option>
														<option value="MONTHLY">MONTHLY</option>
													</select>
												</div>
												<div class="input-element-half">
													<label for="discount_percent">Discount Percent <sup>*</sup></label>
													<input type="text" id="discount_percent" name="discount_percent" value="<?php if(isset($discount_percent)) echo $discount_percent; else echo 0 ?>">
												</div>
												</div>


											</fieldset>


											<div class="col-2">
												<fieldset>
													<legend>Father's Details</legend>
													<div class="input-element">
														<label for="father_name">Is Father Working <sup>*</sup></label>
														<input type="checkbox" id="father_working" name="father_working" <?php if(isset($father_working)) echo 'checked' ?>>
													</div>
													<div class="input-element">
														<label for="father_name">Father_name <sup>*</sup></label>
														<input type="text" id="father_name" name="father_name" value="<?php if(isset($father_name)) echo $father_name ?>">
													</div>
													<div class="input-element">
														<label for="father_occupation">Father Occupation <sup>*</sup></label>
														<input type="text" id="father_occupation" name="father_occupation" value="<?php if(isset($father_occupation)) echo $father_occupation ?>">
													</div>
													<div class="input-element-half">
														<label for="father_income">Father Income <sup>*</sup></label>
														<input type="text" id="father_income" name="father_income" value="<?php if(isset($father_income)) echo $father_income ?>">
													</div>

													<div class="input-element-half">
														<label for="father_work_address">Father Work Address <sup>*</sup></label>
														<input type="text" id="father_work_address" name="father_work_address" value="<?php if(isset($father_work_address)) echo $father_work_address ?>">
													</div>

													<div class="input-element-half">
														<label for="father_phone">Father Phone</label>
														<input type="text" id="father_phone" name="father_phone" value="<?php if(isset($father_phone)) echo $father_phone ?>">
													</div>

													<div class="input-element-half">												
														<label for="father_email">Father Email</label>
														<input type="email" id="father_email" name="father_email" value="<?php if(isset($father_email)) echo $father_email ?>">
													</div>		
												</fieldset>
											</div>


											<div class="col-2">
												<fieldset>
													<legend>Mother's Details</legend>
													<div class="input-element">
														<label for="mother_name">Is Mother Working <sup>*</sup></label>
														<input type="checkbox" id="mother_working" name="mother_working" <?php if(isset($mother_working)) echo 'checked' ?>>
													</div>
													<div class="input-element">
														<label for="mother_name">Mother Name <sup>*</sup></label>
														<input type="text" id="mother_name" name="mother_name" value="<?php if(isset($mother_name)) echo $mother_name ?>">
													</div>
													<div class="input-element">
														<label for="mother_occupation">Mother Occupation <sup>*</sup></label>
														<input type="text" id="mother_occupation" name="mother_occupation" value="<?php if(isset($mother_occupation)) echo $mother_occupation ?>">
													</div>
													<div class="input-element-half">
														<label for="mother_income">Mother Income <sup>*</sup></label>
														<input type="text" id="mother_income" name="mother_income" value="<?php if(isset($mother_income)) echo $mother_income ?>">
													</div>

													<div class="input-element-half">
														<label for="mother_work_address">Mother Work Address <sup>*</sup></label>
														<input type="text" id="mother_work_address" name="mother_work_address" value="<?php if(isset($mother_work_address)) echo $mother_work_address ?>">
													</div>

													<div class="input-element-half">
														<label for="mother_phone">Mother Phone</label>
														<input type="text" id="mother_phone" name="mother_phone" value="<?php if(isset($mother_phone)) echo $mother_phone ?>">
													</div>

													<div class="input-element-half">												
													<label for="mother_email">Mother Email</label>
														<input type="email" id="mother_email" name="mother_email" value="<?php if(isset($mother_email)) echo $mother_email ?>">
													</div>
												</fieldset>
											</div>								

											<button type="submit" class="button send" name="submit">Submit</button>
						
						</div>
</form>
					</div>
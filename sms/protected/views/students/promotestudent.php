<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_student.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>PROMOTE STUDENT</h4>
					</div>
<form action="" method="post" enctype="multipart/form-data">

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
								<?php


									if(!empty($promote) && $promote == true)
									{
										?>
					<div class="row result-table-wrapper">
						<table class="layout">
							<thead>
								<tr>
									<td><input type="checkbox"  class='item_check_all' onclick="select_all_item()"></td>
									<td>Registration number</td>
									<td>Student Name</td>
									<td>Roll no</td>
									<td>Class</td>
									<td>DOB</td>
									<td>Father's Name</td>
								</tr>
							</thead>

							<tbody>
								<?php
									if(isset($students))
										foreach ($students as $key => $value) {

											echo '<tr><td><input type="checkbox" value="'.$value->stu_id.'" name="item[]" class="item_case"></td>
											<td>'.$value->reg_no.'</td>
											<td>'.$value->student_name.'</td>
											<td>'.$value->roll_no.'</td>
											<td>'.$value->class_name.'</td>
											<td>'.$value->dob.'</td>
											<td>'.$value->father_name.'</td>
											</tr>';
										}
								?>
							</tbody>
						</table>
					</div>

					<div class="row helper-menu">
						<input type="hidden" name="security_token" value = "<?= $token ?>"/>
						<input type="hidden" name="fromclass" value = "<?php if(isset($fromclass)) echo $fromclass ?>"/>
						<input type="hidden" name="toclass" value="<?php if(isset($toclass)) echo $toclass ?>">
						<button type="submit" class="button send" name="promote">Promote</button>
					</div>
										<?php
									}
									else
									{
										?>	
					<div class="form">
						<div class="form-header">
							<p><i class="fa fa-pencil"></i>Please fill the Student's details</p>
						</div>					

										<input type="hidden" name="security_token" value = "<?= $token ?>"/>	
											<div class="input-element">
												<label for="fromclass">From Class <sup>*</sup></label>
												<select name="fromclass" id="fromclass">
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
												<label for="toclass">To Class <sup>*</sup></label>
												<select name="toclass" id="toclass">
													<option>Select Class....</option>
												<?php
													if(isset($class))
													foreach ($class as $key => $value) {
														echo '<option  value="'.$value->class_id.'">'.$value->class_name.'</option>';
													}
												?>
												</select>
											</div>

											<button type="submit" class="button send" name="submit">Submit</button>
						</div>
										<?php
									}
									?>
						
</form>
					</div>

					<script>
	function select_all_item() {
    $('input[class=item_case]:checkbox').each(function(){ 
        if($('input[class=item_check_all]:checkbox:checked').length == 0){ 
            $(this).prop("checked", false); 
        } else {
            $(this).prop("checked", true); 
        } 
    });
}</script>
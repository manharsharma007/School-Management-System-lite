<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_attendance.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>TAKE ATTENDANCE</h4>
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
								<?php


									if(!empty($attendance) && $attendance == true)
									{
										?>
					<div class="row result-table-wrapper">
						<table class="layout">
							<col width="80">
  							<col width="auto">
							<col width="auto">
  							<col width="auto">
							<col width="60">
  							<col width="60">
							<col width="60">
							<thead>
								<tr>
									
									<td>S.No</td>
									<td>Registration number</td>
									<td>Student Name</td>
									<td>Roll no</td>
									<td>Present</td>
									<td>Absent</td>
									<td>Late</td>
								</tr>
							</thead>

							<tbody>
								<?php
									$sno = 1;
									if(isset($students))
										foreach ($students as $key => $value) {

											echo '<tr>
											<td>'.$sno.'</td>
											<td>'.$value->reg_no.'</td>
											<td>'.$value->student_name.'</td>
											<td>'.$value->roll_no.'</td>
											<td><input type="radio" value="PRESENT" name="case['.$value->stu_id.']" class="item_case"></td>
											<td><input type="radio" value="ABSENT" name="case['.$value->stu_id.']" class="item_case"></td>
											<td><input type="radio" value="LATE" name="case['.$value->stu_id.']" class="item_case"></td>

											</tr>';
											$sno ++;
										}
								?>
							</tbody>
						</table>
					</div>


					<div class="row helper-menu">
						<input type="hidden" name="security_token" value = "<?= $token ?>"/>
						<input type="hidden" name="class" value="<?php if(isset($class_name)) echo $class_name ?>">
						<div class="row clearfix">
							<p><input type="checkbox" name="is_holiday">Is Holiday</p>
						</div>
						<button type="submit" class="button send" name="save_attendance">Submit</button>
					</div>
										<?php
									}
									else
									{
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

											<button type="submit" class="button send" name="proceed">Submit</button>
						</div>
										<?php
									}
									?>
						
</form>
					</div>
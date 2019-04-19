<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_attendance.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>PERIOD ATTENDANCE</h4>
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

										<?php
										
										foreach ($students as $key => $value) {

											$date = strtotime($value->date);
							                $date = date('M, d Y', $date);

											$att_details = $fetch_students->fetch_attendance_details($value->attendance_id);

											echo '<div class="row date_col"><p>'.$date.'</p></div>';

											if($att_details == false)
											{
												echo '<div class="row holiday_col"><span class="btn btn-wide btn-round bg-yellow"><em>------------------HOILIDAY--------------</em></span></div>';
												
											}
											else
											{
												?>
												<div class="row result-table-wrapper">
						<table class="layout">
							<thead>
								<tr>
									
									<td>S.No</td>
									<td>Registration number</td>
									<td>Student Name</td>
									<td>Roll no</td>
									<td>Status</td>
									<td>Date</td>
								</tr>
							</thead>

							<tbody>
								<?php
									$sno = 1;
									$dt = false;
												foreach ($att_details as $detail) {
													
													$stu_details = $fetch_students->fetch_student_byid($detail->student_id);

													if($detail->status == 'ABSENT')
									                {
									                    $detail->status = '<span class="btn btn-wide btn-round bg-red">ABSENT</span>';
									                }
									                else
									                {
									                	$detail->status = '<span class="btn btn-wide btn-round bg-green">PRESENT</span>';
									                }

													echo '<tr>
													<td>'.$sno.'</td>
													<td>'.$stu_details->reg_no.'</td>
													<td>'.$stu_details->student_name.'</td>
													<td>'.$stu_details->roll_no.'</td>
													<td>'.$detail->status.'</td>
													<td>'.$date.'</td>

													</tr>';
											
													$sno ++;
												}

												?>

							</tbody>
						</table>
					</div>
												<?php
											}

										}

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
										<?php
									}
									?>
						
</form>
					</div>
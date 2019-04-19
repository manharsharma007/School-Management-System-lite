<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_attendance.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>ATTENDANCE DASHBOARD</h4>
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
					

					
					<div class="row clearfix graph_box">
						<div class="row clearfix dashboard-heading">
							<h3>Today's Attendance Reports</h3>
						</div>
						<div class="row">

							<?php
								if(count($today_attendance) == 0)
								{
									?>
										<div class="row">
											<div class="msg notice"><p>No details available</p></div>
										</div>
									<?php
								}
								else
								{
									$class = '';
									foreach ($today_attendance as $att) {

										if($att->class != $class)
										{
											$class = $classes_model->get_class_by_id($att->class)->class_name;
											echo '<div class="row date_col"><p>'.$class.'</p></div>';
										}
				
										if ($att->is_holiday == 1) 
										{
											?>
													<div class="row holiday_col"><span class="btn btn-wide btn-round bg-yellow"><em>------------------HOILIDAY--------------</em></span></div>
											<?php
										}
										else
										{
											?>
											<div class="row result-table-wrapper">
														<table class="layout">
															<thead>
																<tr>
																	
																	<td>Registration number</td>
																	<td>Student Name</td>
																	<td>Roll no</td>
																	<td>Status</td>
																</tr>
															</thead>
															<tbody>
											<?php
											$details = $attendance_model->get_today_attendance_history($att->attendance_id);
											?>
											

														<?php

															foreach ($details as $key => $value) {
																if($value->status == 'ABSENT')
												                {
												                    $value->status = '<span class="btn btn-wide btn-round bg-red">ABSENT</span>';
												                }
												                else
												                {
												                	$value->status = '<span class="btn btn-wide btn-round bg-green">PRESENT</span>';
												                }
																echo '<tr>
																		<td>'.$value->reg_no.'</td>
																		<td>'.$value->student_name.'</td>
																		<td>'.$value->roll_no.'</td>
																		<td>'.$value->status.'</td>
																	</tr>';
															}
									?>
													</tbody>
												</table>
											</div>
											<?php
														
										}
									}
								}

							?>

						</div>
					</div>
			</div>
				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_fees.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>PROCESS FEES</h4>
					</div>

					<div class="row result-table-wrapper">
						<table class="layout">
							<thead>
								<tr>
									
									<td>Registration number</td>
									<td>Student Name</td>
									<td>Roll no</td>
									<td>Class</td>
									<td>Fees</td>
									<td>Previous Balance</td>
									<td>Total</td>
									<td>Status</td>
									<td>Fee Date</td>
									<td>Paid Date</td>
									<td></td>
								</tr>
							</thead>

							<tbody>
								<?php
									if(isset($students))
										foreach ($students as $key => $value) {

											$total = $value->fee_amount + $value->prev_blc;
											
											$value->fee_date = strtotime($value->fee_date);
                							
                							$value->fee_date = date('M, Y', $value->fee_date);
											
											$value->paid_date = strtotime($value->paid_date);
                							
                							$value->paid_date = date('M, Y', $value->paid_date);

											echo '<tr>
											<td>'.$value->reg_no.'</td>
											<td>'.$value->student_name.'</td>
											<td>'.$value->roll_no.'</td>
											<td>'.$value->class_name.'</td>
											<td>'.$value->fee_amount.'</td>
											<td>'.$value->prev_blc.'</td>
											<td>'.$total.'</td>
											<td>'.$value->paid_status.'</td>
											<td>'.$value->fee_date.'</td>
											<td>'.$value->paid_date.'</td>


											<td><a href="#" onclick=\'window.open("'.SITE_URL.'fees/printreceipt?id='.$value->fee_id.'","Print Receipt","width=650,height=800").print()\'>Receipt</a></td></tr>';
										}
								?>
							</tbody>
						</table>
					</div>

				</div>
					
	</form>
				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_fees.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>PROCESS FEES</h4>
					</div>

					<div class="ajax_response"></div>

					<div class="row filters">
						<form action="#" method="post">
							<div class="col-5">
								<div class="field-row">
									<label>Class
									</label>
									<select name="class_filter">
										<option value="">Select class</option>
										<?php
										if(isset($class))
										{
											foreach ($class as $key => $value) {
												echo '<option value="'.$value->class_id.'">'.$value->class_name.'</option>';
											}
										}
										?>
									</select>
								</div>
							</div>

							
							<div class="col-5">
								<div class="field-row">
									<label>Name 
									</label>
									<input type="text" name="name_filter" placeholder="Enter Name">
									
								</div>
							</div>
							<div class="col-5">
								<div class="field-row">
									<label>Registration No.
									</label>
									<input type="text" name="reg_filter" placeholder="Registeration_no">
								</div>
							</div>
							<div class="col-5">
								<div class="field-row">
									<label>Roll no
									</label>
									<input type="text" name="roll_no_filter" placeholder="Ex. 4486">
								</div>
							</div>
							<div class="col-5">
								<input type="submit" name="filter" value="Filter Results" class="button2">
							</div>
							</form>
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
									<td></td>
								</tr>
							</thead>

							<tbody>
								<?php
									if(isset($students))
										foreach ($students as $key => $value) {

											$total = $value->fee_amount + $value->prev_blc;

											echo '<tr>
											<td>'.$value->reg_no.'</td>
											<td>'.$value->student_name.'</td>
											<td>'.$value->roll_no.'</td>
											<td>'.$value->class_name.'</td>
											<td>'.$value->fee_amount.'</td>
											<td>'.$value->prev_blc.'</td>
											<td>'.$total.'</td>


											<td><a href="'.SITE_URL.'fees/payfee?id='.$value->fee_id.'"><i class="fa fa-pencil" aria-hidden="true"></i> Pay</a></td></tr>';
										}
								?>
							</tbody>
						</table>
					</div>

					<div class="row pagination">
						<?php
							if(!empty($pagination_link))
							{
								?>
								<form action="#" method="post">
									<input type="hidden" name="pagination">				
									<input type="hidden" name="class_filter" value="<?php if(isset($filter['class'])) echo $filter['class'] ?>">
									<input type="hidden" name="name_filter" value="<?php if(isset($filter['name'])) echo $filter['name'] ?>">
									<input type="hidden" name="reg_filter" value="<?php if(isset($filter['reg'])) echo $filter['reg'] ?>">
									<input type="hidden" name="roll_no_filter" value="<?php if(isset($filter['roll_no'])) echo $filter['roll_no'] ?>">
									<?= $pagination_link; ?>
								</form>
								<?php
							}
							?>
					</div>	

				</div>
					
	</form>
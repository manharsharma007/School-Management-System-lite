				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_notify.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>Notify Students</h4>
					</div>

<div class="row">
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
</div>


					<div class="row filters">
						<form action="#" method="post">
							<div class="col-3">
								<div class="field-row">
									<label>From 
									</label>
									<input type="date" name="from_filter" placeholder="From">
								</div>
							</div>
							<div class="col-3">
								<div class="field-row">
									<label>To 
									</label>
									<input type="date" name="to_filter" placeholder="To">
								</div>
							</div>
							<div class="col-3">
									<input type="submit" name="filter" value="Filter Results" class="button2">
									<a href="?export" class="button2 btn btn-small btn-red btn-round"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</a>
									<a href="#" class="popup-link button2 btn btn-small btn-red btn-round" data-href="modal_manually"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Notify</a>
								
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
									<td>Status</td>
								</tr>
							</thead>

							<tbody>
								<?php
									if(isset($books))
										foreach ($books as $value) {

											if($value->paid_status == 'PENDING')
							                	$value->paid_status = '<span class="btn btn-wide btn-round bg-yellow">'.$value->paid_status.'</span>';
							                else
							                	$value->paid_status = '<span class="btn btn-wide btn-round bg-green">'.$value->paid_status.'</span>';
											
						                   echo '<tr>
											<td>'.$value->reg_no.'</td>
											<td>'.$value->student_name.'</td>
											<td>'.$value->roll_no.'</td>
											<td>'.$value->class_name.'</td>
											<td>'.$value->fee_amount.'</td>
											<td>'.$value->balance.'</td>
											<td>'.($value->fee_amount + $value->balance).'</td>
											<td>'.$value->paid_status.'</td></tr>';

						   

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
									<input type="hidden" name="from_filter" value="<?php if(isset($filter['from'])) echo $filter['from'] ?>">
									<input type="hidden" name="to_filter" value="<?php if(isset($filter['to'])) echo $filter['to'] ?>">
									<?= $pagination_link; ?>
								</form>
								<?php
							}
							?>
					</div>
					
				</div>
					
	</form>
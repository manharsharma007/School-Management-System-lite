				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_fees.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>DASHBOARD FEES</h4>
					</div>

					<div class="row">
						<div class="col-3 card">
							<div class="card-box bg-blue">
								<div class="card-content">
									<h3><?= (isset($total_students)) ? $total_students : 0; ?></h3>
									<p>Total Students</p>
									<div class="card-icon">
										<i class="fa fa-book" aria-hidden="true"></i>
									</div>
								</div>
								<div class="card-link">
									<p>All students count <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></p>
								</div>
							</div>
						</div>
						<div class="col-3 card">
							<div class="card-box bg-red">
								<div class="card-content">
									<h3><?= (isset($fee_paid_total)) ? $fee_paid_total : 0; ?></h3>
									<p>Fee Paid</p>
									<div class="card-icon">
										<i class="fa fa-users" aria-hidden="true"></i>
									</div>
								</div>
								<div class="card-link">
									<p>Paid Fees</p>
								</div>
							</div>
						</div>
						<div class="col-3 card">
							<div class="card-box bg-yellow">
								<div class="card-content">
									<h3><?= (isset($fee_pending_total)) ? $fee_pending_total : 0; ?></h3>
									<p>Fee Pending</p>
									<div class="card-icon">
										<i class="fa fa-users" aria-hidden="true"></i>
									</div>
								</div>
								<div class="card-link">
									<p>Pending Fees</p>
								</div>
							</div>
						</div>
					</div>	
					
				</div>

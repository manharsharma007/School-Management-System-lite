				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_student.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>Students Dashboard</h4>
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
									<h3><?= (isset($total_classes)) ? $total_classes : 0; ?></h3>
									<p>Classes</p>
									<div class="card-icon">
										<i class="fa fa-users" aria-hidden="true"></i>
									</div>
								</div>
								<div class="card-link">
									<p><a href="<?= SITE_URL.'students/addclass' ?>">View <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a></p>
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
									<p>Pending Fees <i class="fa fa-arrow-circle-right" aria-hidden="true"></i></p>
								</div>
							</div>
						</div>
					</div>	

					
					<div class="row page-heading">
						<h4>Search</h4>
					</div>

					<div class="row clearfix">
						<div class="col-2">

							<form action="<?= SITE_URL.'students/viewstudent' ?>" method="post">
					
								<div class="form">
									<div class="form-header">
										<p><i class="fa fa-pencil"></i> Search Student</p>
									</div>
									
									<div class="form-body">
									     <div class="input-element">
											<label for="name">Student name</label>
											<input type="text" id="name" name="name_filter">
										</div>
										<div class="input-element">
											<label for="name">Registraion Number</label>
											<input type="text" id="name" name="reg_filter">
										</div>
										<div class="input-element-half">
											<label for="name">Select Class</label>
											<select name="class_filter">
												<?php
													if(isset($class))
													foreach ($class as $key => $value) {
														echo '<option  value="'.$value->class_id.'">'.$value->class_name.'</option>';
													}
												?>
											</select>
										</div>
										<div class="input-element-half">
											<label for="name">Roll number</label>
											<input type="text" id="name" name="roll_no_filter">
										</div>
										<input type="submit" class="button" name="filter">
									</div>

								</div>
							</form>
							
						</div>


						<div class="col-2">

							<form action="<?= SITE_URL.'fees/processfees' ?>" method="post">
					
								<div class="form">
									<div class="form-header">
										<p><i class="fa fa-pencil"></i> Search Fee Details</p>
									</div>
									
									<div class="form-body">
									     <div class="input-element">
											<label for="name">Name</label>
											<input type="text" name="name_filter" placeholder="Enter Name">
										</div>
										<div class="input-element">
											<label for="name">Registration No.</label>
											<input type="text" name="reg_filter" placeholder="Registeration_no">
										</div>
										<div class="input-element-half">
											<label for="name">Roll no</label>
											<input type="text" name="roll_no_filter" placeholder="Ex. 4486">
										</div>
										<div class="input-element-half">
											<label for="name">Class</label>
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
										<input type="submit" class="button" name="filter">
									</div>

								</div>
							</form>
							
						</div>

					</div>	

				</div>

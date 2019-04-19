				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_certificate.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>PRINT CERTIFICATE</h4>
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
					
					<?php
						if(!empty($issue_status) && $issue_status == true) 
						{

					?>

					<!-- Fees Receipt Design -->
					<div class="print">
						<div class="page">
						<div class="row cert-designer">
							<div class="row cert-header">
								<span class="image"><?php if(isset($institute_logo)) echo '<img src="'.SITE_URL.$institute_logo.'">'; ?></span>
								<h1><?php echo $institute_name ?></h1>
								<p class="sub-heading"><?php echo $institute_address ?></p>
								<p>UDISE CODE : <span><?php echo $school_code ?></span></p>
							</div>

							<div class="row cert-title">
								<span>SCHOOL LEAVING CERTIFICATE</span>
							</div>

							<div class="row misc-details">
								<div class="row">
									<div class="col-2">
										<p>Student's Name: <span><?php echo $name ?></span></p>
									</div>
									<div class="col-2">									
										<p>Date Of Issue: <span><?php echo $dateofissue ?></span></p>
									</div>
								</div>
								<div class="row">
									<p>DOB <span><?php echo $dob ?></span></p>
									<p>SRN <span><?php echo $srn ?></span></p>
									<p>Father's Name <span><?php echo $father_name ?></span></p>
									<p>Mother's Name <span><?php echo $mother_name ?></span></p>
								</div>

							</div>

							<div class="row cert-details">
								<p>It is certified that <span><?php echo $name ?></span> attended this school upto <span><?php echo $dateofissue ?></span>. He/She has paid all sums dueto the schooland was allowed on the above date to withdraw his/her name. He/She was reading in class <span><?php echo $class ?></span> in this school</p>
							</div>

							<div class="row cert-footer">
								<div class="row sig_field"></div>
								<div class="row">
									<div class="col-2">
										<p>Date of Issue <span><?php echo $dateofissue ?></span></p>
									</div>
									<div class="col-2">									
										<p><span>Signatue of Principal</span></p>
									</div>
								</div>
							</div>					

						</div>
						</div>

						
					</div>

					<?php
						}
					?>

				</div>
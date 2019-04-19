				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_fees.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>PRINT RECEIPT</h4>
					</div>



					<!-- Fees Receipt Design -->
					<div class="print">
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
						<div class="page">
						<div class="row receipt-designer">
							<div class="row receipt-header">
								<span class="image"><?php if(isset($institute_logo)) echo '<img src="'.SITE_URL.$institute_logo.'">'; ?></span>
								<span><?php if(isset($institute_name)) echo $institute_name ?></span>
							</div>

							<div class="row receipt-title">
								<span>Fee Receipt/Invoice: [Student Copy]</span>
							</div>

							<div class="row misc-details">
								<div class="col-2">
									<p><span>Date : </span><?php echo $date; ?></p>
								</div>
								<div class="col-2">
									<p><span>Ref# : </span><?php echo $ref; ?></p>
								</div>
							</div>

							<div class="row student-details">
								<div class="row">
									<div class="col-2">
										<p><span>Name : </span><?php echo $name; ?></p>
									</div>
									<div class="col-2">
										<p><span>Class : </span><?php echo $class; ?></p>
									</div>
								</div>
								<div class="row">
									<div class="col-2">
										<p><span>Father's Name : </span><?php echo $father_name; ?></p>
									</div>
								</div>
							</div>

							<div class="row fee-details">
								<div class="row detail-header">
									
									<div class="col-3"><p><span>S.No</span></p></div>
									<div class="col-3"><p><span>Title</span></p></div>
									<div class="col-3"><p><span>Amount</span></p></div>
									
								</div>

								<div class="row detail-body">
									<div class="row">
										<div class="col-3"><p><span>1</span></p></div>
										<div class="col-3"><p><span>* School Fees (<?php echo $class; ?>)</span></p></div>
										<div class="col-3"><p><?php echo $fees; ?></p></div>
									</div>
									<div class="row">
										<div class="col-3"><p><span>2</span></p></div>
										<div class="col-3"><p><span>Previous Balance</span></p></div>
										<div class="col-3"><p><?php echo $prev_blc; ?></p></div>
									</div>
									
								</div>

								<div class="row detail-footer">
									<div class="row">
										
											<div class="col-2"><p><span>Total</span></p></div>
											<div class="col-2"><p><span><?php echo $total; ?></span></p></div>
										
									</div>
									<div class="row">
										
											<div class="col-2"><p><span>Amount Paid</span></p></div>
											<div class="col-2"><p><span><?php echo $amount_paid; ?></span></p></div>
										
									</div>
									<div class="row">
										
											<div class="col-2"><p><span>Remaining Balance</span></p></div>
											<div class="col-2"><p><span><?php echo $balance; ?></span></p></div>
										
									</div>
								</div>

								<div class="row cert-footer">
									<div class="row sig_field"></div>
									<div class="row">
										<div class="col-2">
											<p>Paid Date <span><?php echo $paiddate ?></span></p>
										</div>
										<div class="col-2">									
											<p><span>Receiver's Signatue</span></p>
										</div>
									</div>
								</div>	
							</div>

							<div class="row note">
								<p>Note : This is a computer generated receipt</p>
							</div>				

						</div>
						</div>

						<div class="page">
						<!-- Fees Receipt Design -->
						<div class="row receipt-designer">
							<div class="row receipt-header">
								<span class="image"><?php if(isset($institute_logo)) echo '<img src="'.SITE_URL.$institute_logo.'">'; ?></span>
								<span><?php if(isset($institute_name)) echo $institute_name ?></span>
							</div>

							<div class="row receipt-title">
								<span>Fee Receipt/Invoice: [School Copy]</span>
							</div>

							<div class="row misc-details">
								<div class="col-2">
									<p><span>Date : </span><?php echo $date; ?></p>
								</div>
								<div class="col-2">
									<p><span>Ref# : </span><?php echo $ref; ?></p>
								</div>
							</div>

							<div class="row student-details">
								<div class="row">
									<div class="col-2">
										<p><span>Name : </span><?php echo $name; ?></p>
									</div>
									<div class="col-2">
										<p><span>Class : </span><?php echo $class; ?></p>
									</div>
								</div>
								<div class="row">
									<div class="col-2">
										<p><span>Father's Name : </span><?php echo $father_name; ?></p>
									</div>
								</div>
							</div>

							<div class="row fee-details">
								<div class="row detail-header">
									
									<div class="col-3"><p><span>S.No</span></p></div>
									<div class="col-3"><p><span>Title</span></p></div>
									<div class="col-3"><p><span>Amount</span></p></div>
									
								</div>

								<div class="row detail-body">
									<div class="row">
										<div class="col-3"><p><span>1</span></p></div>
										<div class="col-3"><p><span>* School Fees (<?php echo $class; ?>)</span></p></div>
										<div class="col-3"><p><?php echo $fees; ?></p></div>
									</div>
									<div class="row">
										<div class="col-3"><p><span>2</span></p></div>
										<div class="col-3"><p><span>Previous Balance</span></p></div>
										<div class="col-3"><p><?php echo $prev_blc; ?></p></div>
									</div>
									
								</div>

								<div class="row detail-footer">
									<div class="row">
										
											<div class="col-2"><p><span>Total</span></p></div>
											<div class="col-2"><p><span><?php echo $total; ?></span></p></div>
										
									</div>
									<div class="row">
										
											<div class="col-2"><p><span>Amount Paid</span></p></div>
											<div class="col-2"><p><span><?php echo $amount_paid; ?></span></p></div>
										
									</div>
									<div class="row">
										
											<div class="col-2"><p><span>Remaining Balance</span></p></div>
											<div class="col-2"><p><span><?php echo $balance; ?></span></p></div>
										
									</div>
								</div>

								<div class="row cert-footer">
									<div class="row sig_field"></div>
									<div class="row">
										<div class="col-2">
											<p>Paid Date <span><?php echo $paiddate ?></span></p>
										</div>
										<div class="col-2">									
											<p><span>Receiver's Signatue</span></p>
										</div>
									</div>
								</div>	
							</div>

							<div class="row note">
								<p>Note : This is a computer generated receipt</p>
							</div>				

						</div>
</div>
					</div>

				</div>
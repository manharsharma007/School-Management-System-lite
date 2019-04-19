				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_index.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>Home</h4>
					</div>
					

					<div class="row clearfix">


						<div class="row graph_box">

							<div class="row clearfix dashboard-heading">
								<h3>Total Students</h3>
							</div>

								<?php 
									if($total_students == 0 && $total_pending == 0 && $total_paid == 0 && $total_classes == 0)

									{
										?>
											<div class="row">
												<div class="msg notice"><p>No details available</p>
											</div>
										<?php
									}
									else
									{
										if($internet == true)
										{
										?>

											<div class="row">
												<noscript>
													<div class="msg notice"><p>Javascript is required to properly run the application.</p>
												</noscript>
											</div>
											<div id="overview" style="width: 600px; height: 400px; margin:0 auto;"></div>
										<?php
										}
										else
										{
											?>
											<div class="row">
												<div class="msg notice"><p>Graphs will be available if your are connected to the internet</p>
											</div>
											<table style="width:400px;" class="layout">
												<thead>
													<tr><td>Data</td><td>Value</td></tr>
												</thead>
												<tbody>
													<tr><td>Total Students</td><td><?= $total_students ?></td></tr>
													<tr><td>Total Paid Students</td><td><?= $total_paid ?></td></tr>
													<tr><td>Total Unpaid Students</td><td><?= $total_pending ?></td></tr>
													<tr><td>Total Classes</td><td><?= $total_classes ?></td></tr>
												</tbody>
												
											</table>
											<?php
										}
									}
								?>
						</div>
					</div>


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

					<div class="row clearfix graph_box">
						<div class="row clearfix dashboard-heading">
							<h3>Today's Fee Reports</h3>
						</div>
						<div class="row">
							<div class="col-2 card">
								<div class="card-box bg-blue">
									<div class="card-content">
										<h3><?= (isset($today_paid) && $today_paid > 0) ? $today_paid : 0; ?></h3>
										<p>Today's Paid</p>
										<div class="card-icon">
											<i class="fa fa-book" aria-hidden="true"></i>
										</div>
									</div>
									
								</div>
							</div>


							<div class="col-2 card">
								<div class="card-box bg-green">
									<div class="card-content">
										<h3><?= (isset($today_pending)) ? $today_pending : 0; ?></h3>
										<p>Today's Pending</p>
										<div class="card-icon">
											<i class="fa fa-book" aria-hidden="true"></i>
										</div>
									</div>
									
								</div>
							</div>

						</div>
					</div>

					<div class="row clearfix graph_box">
						<div class="row clearfix dashboard-heading">
							<h3>Month's Fee Reports</h3>
						</div>
						<div class="row">
							<div class="col-2 card">
								<div class="card-box bg-blue">
									<div class="card-content">
										<h3><?= (isset($month_paid) && $month_paid > 0) ? $month_paid : 0; ?></h3>
										<p>Month's Paid</p>
										<div class="card-icon">
											<i class="fa fa-book" aria-hidden="true"></i>
										</div>
									</div>
									
								</div>
							</div>


							<div class="col-2 card">
								<div class="card-box bg-green">
									<div class="card-content">
										<h3><?= (isset($month_pending)) ? $month_pending : 0; ?></h3>
										<p>Month's Pending</p>
										<div class="card-icon">
											<i class="fa fa-book" aria-hidden="true"></i>
										</div>
									</div>
									
								</div>
							</div>
						</div>
					</div>



					<div class="row clearfix graph_box">
						<div class="row clearfix dashboard-heading">
							<h3>Total Record till date</h3>
						</div>

								<?php 
									if($total_students == 0 && $total_pending == 0 && $total_paid == 0 && $total_classes == 0)

									{
										?>
											<div class="row">
												<div class="msg notice"><p>No details available</p>
											</div>
										<?php
									}
									else
									{
										if($internet == true)
										{
										?>
										
											<div class="row">
												<noscript>
													<div class="msg notice"><p>Javascript is required to properly run the application.</p>
												</noscript>
											</div>
											<div id="year" style="width: 1000px; height: 300px; margin:0 auto;"></div>
										<?php
										}
										else
										{
											?>
											<div class="row">
												<div class="msg notice"><p>Graphs will be available if your are connected to the internet</p>
											</div>
											<table style="width:400px;" class="layout">
												<thead>
													<tr><td>Data</td><td>Value</td></tr>
												</thead>
												<tbody>
													<tr><td>Total Students</td><td><?= $total_students ?></td></tr>
													<tr><td>Total Unpaid Students</td><td><?= $total_pending ?></td></tr>
													<tr><td>Total Paid Students</td><td><?= $total_paid ?></td></tr>
													<tr><td>Total Classes</td><td><?= $total_classes ?></td></tr>
												</tbody>
												
											</table>
											<?php
										}
									}
								?>
					</div>






							
				</div>
<script type="text/javascript">
var element =  document.getElementById('overview');
var year =  document.getElementById('year');
if (typeof(element) != 'undefined' && element != null)
{
	google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Total Record'],
          ["Total Students",<?= $total_students ?>],

          ["Total Unpaid Students", <?= $total_pending ?>],

          ["Total Paid Students", <?= $total_paid ?>],

          ["Total Classes", <?= $total_classes ?>]
        ]);

        var options = {
          title: ''
        };

        var chart = new google.visualization.PieChart(document.getElementById('overview'));

        chart.draw(data, options);
      }

}

if (typeof(year) != 'undefined' && year != null)
{
	google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawBasic);

function drawBasic() {

      var data = google.visualization.arrayToDataTable([
        ['Record', 'Total Record',],
        ["Total Students",<?= $total_students ?>],

          ["Total Unpaid Students", <?= $total_pending ?>],

          ["Total Paid Students", <?= $total_paid ?>],

          ["Total Classes", <?= $total_classes ?>]
      ]);

      var options = {
        title: 'Total Record till date',
        chartArea: {width: '60%'},
        hAxis: {
          title: 'Total Record',
          minValue: 0
        },
        vAxis: {
          title: ''
        }
      };

      var chart = new google.visualization.BarChart(document.getElementById('year'));

      chart.draw(data, options);
    }
}
</script>


					
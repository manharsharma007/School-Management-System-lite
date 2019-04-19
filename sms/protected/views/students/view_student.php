				<div class="row header">
					<div class="col admin-menu">
						<?php include(VIEWS.DS.'menus/_student.php') ?>
					</div>
				</div>
				<div class="row content">
					<div class="row page-heading">
						<h4>VIEW STUDENTS</h4>
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
					<div class="row helper-menu helper-menu-right">				
							<?php $query_str = ''; ?>
							<?php if(isset($filter['class'])) $query_str .= '&class='.$filter['class'] ?>
							<?php if(isset($filter['name'])) $query_str .= '&name='.$filter['name'] ?>
							<?php if(isset($filter['reg'])) $query_str .= '&reg='.$filter['reg'] ?>
							<?php if(isset($filter['roll_no'])) $query_str .= '&roll_no='.$filter['roll_no'] ?>	
							<a href="#" class="button2 btn btn-small btn-red btn-round popup-link" data-href="modal_import"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Import CSV</a>	
							&nbsp;
							<a href="?export<?php echo $query_str ?>" class="button2 btn btn-small btn-orange btn-round"><i class="fa fa-download" aria-hidden="true"></i> Export data</a>	
					</div>
					<div class="row result-table-wrapper">
						<table class="layout">
							<thead>
								<tr>
									
									<td>Registration number</td>
									<td>Student Name</td>
									<td>Roll no</td>
									<td>Class</td>
									<td>DOB</td>
									<td>Father's Name</td>
									<td>Status</td>
									<td></td>
									<td></td>
								</tr>
							</thead>

							<tbody>
								<?php
									if(isset($students))
										foreach ($students as $key => $value) {

											echo '<tr class="edit_tr" id="tr_'.$value->stu_id.'" data-id="'.$value->stu_id.'">
											<td>'.$value->reg_no.'</td>
											<td>'.$value->student_name.'</td>
											<td>'.$value->roll_no.'</td>
											<td>'.$value->class_name.'</td>
											<td>'.$value->dob.'</td>
											<td>'.$value->father_name.'</td>
											<td>'.$value->student_status.'</td>


											<td><a href="'.SITE_URL.'students/editstudent?id='.$value->student_id.'"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a></td>
											<td><a href="#" id="'.$value->stu_id.'" class="delete_student"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td></tr>';
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

					<script>
						
					jQuery(document).ready(function($)
					{
						$(".edit_tr .delete_student").on('click', function(e)
						{
							e.preventDefault();
						var ID=$(this).attr('id');
						var table_row = $('#tr_'+ID);


						$.ajax({ //ajax form submit
					                url : "<?= SITE_URL ?>students/deletestudent",
					                type: "GET",
					                data : 'id='+ID,
					                dataType : "json",
					                contentType: false,
					                cache: false,
					                processData:false
					            }).done(function(res){
					                    $(".ajax_response").html( res.text );
					                    if(res.code == 1)
					                    	table_row.remove();
					            });
					     });
					});
					</script>		

				</div>


					<div class="popup-container" id="modal_import">
						<div class="popup-window">
							<div class="popup-header"><i class="fa fa-pencil"></i> Please choose CSV file<a href="#" class="popup-close right" data-href="modal"><i class="fa fa-times" aria-hidden="true"></i></a></div>
							<div class="popup-content">
						
										<form action="#" data-action="<?= SITE_URL ?>/students/import" id="form_import" class="clearfix form form_ajax" method="post">
										
										<div class="row ajax_response"></div>
										<div class="form-body">
											<div class="input-item file-display __text-left"></div>

											<div class="upload-item">
												<label>Students CSV</label>
												<input type="file" id="file_import" name="csv_file" value="" class="file file-upload">
												<label class="title" for="file_import"><i class="fa fa-paperclip" aria-hidden="true"></i> Select File</label>							
											</div>								

											<button type="submit" class="button send">Submit</button>
										</div>
									</form>
							</div>
						</div>
					</div>
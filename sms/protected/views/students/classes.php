				<div class="col-3" style="margin:0 auto;float:none;">
						<div class="page-title bg-red">
							<h4>Classes</h4>
						</div>
					<div class="ajax_response"></div>
						<div class="row result-table-wrapper">
							<table class="layout">
								<colgroup>
									<col width="auto">
									<col width="auto">
									<col width="50px">
								</colgroup>
								<thead>
									<tr>
										<td>ID</td>
										<td>Name</td>
										<td>Fees</td>
										<td>Exclusion Months</td>
										<td></td>
									</tr>
								</thead>

								<tbody>
									<?php
									if(isset($classes))
										foreach ($classes as $key => $value) {

											$months = '';

											if(!empty($value->exclusion_months))
											{
												$value->exclusion_months = unserialize($value->exclusion_months);
												foreach ($value->exclusion_months as $k => $month) {
													$dateObj   = DateTime::createFromFormat('!m', $month);

													if($k == 0)
														$months = $dateObj->format('F');
													else
													{
														$months .= ',';
														$months .=	$dateObj->format('F');
													}
												}
											}
											
											echo '<tr class="edit_tr" id="tr_'.$value->class_id.'" data-id="'.$value->class_id.'"><td>'.$value->class_id.'</td>

	<td class="edit_td"><span id="first_'.$value->class_id.'" class="text">'.$value->class_name.'</span>
	<input type="text" value="'.$value->class_name.'" class="editbox" id="first_input_'.$value->class_id.'"></td>
											
											<td class="edit_td"><span id="second_'.$value->class_id.'" class="text">'.$value->fees.'</span>
	<input type="text" value="'.$value->fees.'" class="editbox" id="second_input_'.$value->class_id.'"></td>

	<td>'.$months.'</td>

											<td><a href="#" id="'.$value->class_id.'" class="delete_class"><i class="fa fa-trash-o" aria-hidden="true"></i></a></td></tr>';
										}
								?>
								</tbody>
							</table>
						</div>
					</div>

					<script>
						
					jQuery(document).ready(function($)
					{
						$(".edit_tr .delete_class").on('click', function(e)
						{
							e.preventDefault();
						var ID=$(this).attr('id');
						var table_row = $('#tr_'+ID);


						$.ajax({ //ajax form submit
					                url : "<?= SITE_URL ?>students/deleteclass",
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


						$(".edit_tr").click(function()
{
var ID=$(this).attr('data-id');
$("#first_"+ID).hide();
$("#first_input_"+ID).show();
$("#second_"+ID).hide();
$("#second_input_"+ID).show();
}).change(function()
{
var ID=$(this).attr('data-id');
var first = $("#first_input_"+ID).val();
var second = $("#second_input_"+ID).val();
var dataString = 'class_name='+first+'&fees='+second+'&id='+ ID;

$.ajax({
type: "POST",
url: "<?= SITE_URL ?>students/updateclass",
data: dataString,
cache: false,
dataType: "json",
success: function(res)
{
	$(".ajax_response").html( res.text );
    var scrollPos =  $(".ajax_response").offset().top;
    $(window).scrollTop(scrollPos);
	$("#first_"+ID).html(first);
	$("#second_"+ID).html(second);
}
});

});

// Edit input box click action
$(".editbox").mouseup(function() 
{
return false
});

// Outside click action
$('body').mouseup(function()
{
$(".editbox").hide();
$(".text").show();
});

					});
					</script>
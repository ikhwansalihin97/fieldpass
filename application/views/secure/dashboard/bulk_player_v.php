<?php
$this->load->view('secure/m_header');
?>
	
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
			<!--begin::Card-->
			<div class="card card-custom gutter-b">
				<div class="card-header">
					<h3 class="card-title">
						<?php echo isset($card_title) && $card_title != '' ? $card_title : 'Please Set Card Title';?>
					</h3>
					<div class="card-toolbar">
						<div class="example-tools justify-content-center">
							<a href="<?php echo base_url() . 'assets/template/SCL 2022 Fantasy Sheet.xlsx';?>" class="btn btn-primary mr-2"> Template Sample </a>
						</div>
					</div>
				</div>
				<!--begin::Form-->
				<form class="form" method="POST" action="<?php echo base_url() .'secure/bulk_player';?>" id="js_bulk_player">
					<div class="card-body">
						<div class="form-group">
							<label>File Browser</label>
							<div></div>
							<div class="custom-file">
								<input type="file" class="custom-file-input" name="bulk_player" id="customFile" accept=".xlsx, .xls, .csv"/>
								<label class="custom-file-label" for="customFile">Choose file</label>
							</div>
							<span class="form-text text-muted">Allowed file type : xls, xlsx or csv</span>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-lg-6">
								<button type="reset" class="btn btn-secondary">Cancel</button>
							</div>
							<div class="col-lg-6 text-lg-right">
								<button type="submit" class="btn btn-primary mr-2"><?php echo isset($form_data['id']) && $form_data['id'] != '' ? 'Update' : 'Submit';?></button>
							</div>
						</div>
					</div>
				</form>
				<!--end::Form-->
			</div>
			<!--end::Card-->
			
			<div class="card card-custom gutter-b bulkResultCard" style="display:none;">
				<div class="card-header">
					<h3 class="card-title">
						Bulk Upload Result
					</h3>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead class="">
								<tr>
									<th scope="col" width="100">#</th>
									<th scope="col" width="250">Data</th>
									<th scope="col" width="150">Feedback</th>
								</tr>
							</thead>
							<tbody class="feedbackTable">
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--end::Container-->
	</div>
	<!--end::Entry-->

		
	


<?php
$this->load->view('secure/m_footer');
?>

<script type="text/javascript">
$(function() 
{
	$('#js_bulk_player').submit(function(event){	
		event.preventDefault();
		// var values = $(this).serialize();
		var formData = new FormData($(this)[0]);
		
		$(":input").removeClass("is-invalid");
		
		$.ajax({
			url: baseUrl + 'secure/bulk_player',
			method: "POST",
			data: formData,
			dataType:'json',
			async: false,
			cache: false,
			contentType: false,
			enctype: 'multipart/form-data',
			processData: false,
			success: function(response){
				if(response['result'] == 'info')
				{
					toastr.info('Bulk Process Finished');
					$('.feedbackTable').html(response['tableData']);
					$('.bulkResultCard').css("display","flex");
				}
				else
				{
					toastr.error('Error Occured');
					location.reload();
				}
			}
		});
	});
	
});
</script>

<!--begin::Page Scripts(used by this page)-->
<script src="<?php echo base_url();?>template/metronic/dist/assets/js/pages/crud/ktdatatable/base/success_bulk_player.js?v=<?php echo time();?>"></script>
<script src="<?php echo base_url();?>template/metronic/dist/assets/js/pages/crud/ktdatatable/base/failed_bulk_player.js?v=<?php echo time();?>"></script>
<!--end::Page Scripts-->

<?php
$this->load->view('secure/m_footer_close');
?>

<?php
$this->load->view('secure/m_header');
?>
	
	<!--begin::Entry-->
	<div class="d-flex flex-column-fluid">
		<!--begin::Container-->
		<div class="container">
                    <!--begin::Notice-->
                    <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                            <div class="alert-icon">
                                    <span class="svg-icon svg-icon-primary svg-icon-xl">
                                            <!--begin::Svg Icon | path:assets/media/svg/icons/Tools/Compass.svg-->
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24" />
                                                            <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3" />
                                                            <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero" />
                                                    </g>
                                            </svg>
                                            <!--end::Svg Icon-->
                                    </span>
                            </div>
                            <div class="alert-text">Fieldpass is the brand name and the second product of quad data sdn bhd, providing data management solutions for managing campaign.
                            <!--<a class="font-weight-bold" href="https://fullcalendar.io/docs/v4" target="_blank">FullCalendar v4 Documentation</a>.-->
                            <br />
                            <span class="label label-danger label-inline font-weight-bold">FIELDPASS</span></div>
                    </div>
                    <!--end::Notice-->
                    <!--begin::Example-->
                    <!--begin::Card-->
                    <div class="card card-custom">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label"><?php echo isset($title) && $title != '' ? $title : 'Card Title Missing';?></h3>
                            </div>
                        </div>
                        <form class="form" method="POST" action="<?php echo base_url() .'secure/system_settings';?>" id="js_system_settings">
                            <div class="card-body">
                                <h3 class="font-size-lg text-dark font-weight-bold mb-6">1. System Info:</h3>
                                <div class="mb-15">
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Allowed Transfer:</label>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" name="set_transfer_allowed" placeholder="" value="<?php echo isset($settings_data['set_transfer_allowed']['value']) && $settings_data['set_transfer_allowed']['value'] != '' ? $settings_data['set_transfer_allowed']['value'] : '1';?>" min="1" max="15" />
                                            <span class="form-text text-muted">Please enter your allowed transfer</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-lg-3 col-form-label">Same Team Limit:</label>
                                        <div class="col-lg-6">
                                            <input type="number" class="form-control" placeholder="" name="same_team_limit" value="<?php echo isset($settings_data['same_team_limit']['value']) && $settings_data['same_team_limit']['value'] != '' ? $settings_data['same_team_limit']['value'] : '1';?>" min="1" max="15"/>
                                            <span class="form-text text-muted">Please enter your same team limit</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-end">
                                    <div class="text-lg-right">
                                        <a href="<?= base_url('execute-shell-script') ?>" class="btn btn-dark executeScriptBtn mr-2">Run Fantasy Subs</a>
                                        <button type="submit" class="btn btn-primary mr-2 submitBtn" disabled>Update</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php
                    #ad($this->session->userdata());
                    ?>
                    <?php
                    #ad($match_calendar);
                    ?>
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
        // Add click event listener to the button
        $('.executeScriptBtn').on('click', function(e) {
            e.preventDefault();

            // Disable the button to prevent multiple clicks
            $(this).prop('disabled', true);

            // Make an AJAX request to execute the shell script
            $.ajax({
                url: $(this).attr('href'),
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    // Enable the button after the request is complete
                    $('.executeScriptBtn').prop('disabled', false);

                    // Show SweetAlert2 only if the shell script execution is successful
                    if (response.result === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Shell script executed successfully!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                },
                error: function() {
                    // Enable the button in case of an error
                    $('.executeScriptBtn').prop('disabled', false);
                }
            });
        });

        // Add change event listener to all input elements
        $('input').on('change', function(){
            // Enable submit button when any input changes
            $('.submitBtn').prop('disabled', false);
        });
        
        $('#js_system_settings').submit(function(event){	
                event.preventDefault();
                // var values = $(this).serialize();
                var formData = new FormData($(this)[0]);

                $(":input").removeClass("is-invalid");
                $("select").removeClass("is-invalid");

                $.ajax({
                        url: baseUrl + 'secure/system_settings',
                        method: "POST",
                        data: formData,
                        dataType:'json',
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response){
                            if(response['result'] == 'success')
                            {
                                toastr.success('Successfully update system settings');
                                setTimeout(function(){
                                    location.reload();
                                }, 2000);
                            }
                            else
                            {
                                toastr.error(response['message']);
                                if(response['type'] == 'input')
                                        $("input[name='"+response['input']+"']").addClass("is-invalid");
                                else
                                        $("#"+response['input']).addClass("is-invalid");

                            }
                        }
                });
        });

});
</script>
<?php
$this->load->view('secure/m_footer_close');
?>

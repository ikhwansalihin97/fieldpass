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
                                            <h3 class="card-label">Match Calendar</h3>
                                    </div>
                                    <div class="card-toolbar">
                                            <a href="<?php echo base_url();?>secure/match_form" class="btn btn-light-primary font-weight-bold">
                                            <i class="ki ki-plus icon-md mr-2"></i>Add New Matches</a>
                                    </div>
                            </div>
                            <div class="card-body">
                                <div id="kt_calendar"></div>
                            </div>
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
        
<!--begin::Page Vendors(used by this page)-->
<script src="<?php echo base_url();?>template/metronic/dist/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js?v=<?php echo time();?>"></script>
<!--end::Page Vendors-->
<!--begin::Page Scripts(used by this page)
<!--end::Page Scripts-->

<script type="text/javascript">
$(function() 
{
"use strict";

var KTCalendarBasic = function() {

return {
    //main function to initiate the module
    init: function() {
        var todayDate = moment().startOf('day');
        var YM = todayDate.format('YYYY-MM');
        var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
        var TODAY = todayDate.format('YYYY-MM-DD');
        var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

        var calendarEl = document.getElementById('kt_calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'bootstrap', 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            themeSystem: 'bootstrap',

            isRTL: KTUtil.isRTL(),

            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },

            height: 800,
            contentHeight: 780,
            aspectRatio: 3,  // see: https://fullcalendar.io/docs/aspectRatio

            nowIndicator: true,
            now: TODAY + 'T09:25:00', // just for demo

            views: {
                dayGridMonth: { buttonText: 'month' },
                timeGridWeek: { buttonText: 'week' },
                timeGridDay: { buttonText: 'day' }
            },

            defaultView: 'dayGridMonth',
            defaultDate: TODAY,

            editable: true,
            eventLimit: true, // allow "more" link when too many events
            navLinks: true,
            events: <?php echo $match_calendar; ?>,

            eventRender: function(info) {
                var element = $(info.el);

                if (info.event.extendedProps && info.event.extendedProps.description) {
                    if (element.hasClass('fc-day-grid-event')) {
                        element.data('content', info.event.extendedProps.description);
                        element.data('placement', 'top');
                        KTApp.initPopover(element);
                    } else if (element.hasClass('fc-time-grid-event')) {
                        element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    } else if (element.find('.fc-list-item-title').lenght !== 0) {
                        element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                    }
                }
            }
        });

        calendar.render();
    }
};
}();

jQuery(document).ready(function() {
KTCalendarBasic.init();
});
	
});
</script>
<?php
$this->load->view('secure/m_footer_close');
?>

jQuery(document).ready(function(){

    
    // init availability calendar
    jQuery('.lcw_availability_calendar').each(function(){
        var bookingWidget;

        if(jQuery('.lcw_daterange')) {
            bookingWidget = jQuery('.lcw_daterange');
        }

        var dates = jQuery(this).data('disableddates');
        var parent = jQuery(this);

        jQuery(this).find('.calendar').map(function(index) {
            jQuery(this).datepicker({
                format: 'yyyy-mm-dd',
                defaultViewDate: {
                    year: (new Date()).getFullYear(),
                    month: (new Date()).getMonth() + index,
                    date: 1
                },
                datesDisabled: dates,
                updateViewDate: false,
                maxViewMode: 'year',
                startDate: new Date(),
                endDate: "+1y",
                showOnFocus: false
            });
        });

        var orderMonth = function(e) {
            var target = e.target;
            var date = e.date;
            var calendars =  parent.find('.calendar');
            var positionOfTarget = calendars.index(target);
            calendars.each(function(index) {
                if (this === target) {
                    return;
                }
                var newDate = new Date(date);
                newDate.setUTCDate(1);
                newDate.setMonth(
                    date.getMonth() + index - positionOfTarget
                );

                jQuery(this).datepicker('_setDate', newDate, 'view');
            });
        };
        jQuery('.calendar').on('changeMonth', orderMonth);

        // keep dates in sync
        jQuery(this).find('.calendar').on('changeDate', function(e) {
            var calendars = parent.find('.calendar');
            var target = e.target;
            var newDates = jQuery(target).datepicker('getUTCDates');
            calendars.each(function() {
                if (this === e.target) {
                    return;
                }
                var currentDates = jQuery(this).datepicker('getUTCDates');
                if (
                    currentDates &&
                    currentDates.length === newDates.length &&
                    currentDates.every(function(currentDate) {
                        return newDates.some(function(newDate) {
                            return currentDate.toISOString() === newDate.toISOString();
                        })
                    })
                ) {
                    return;
                }

                jQuery(this).datepicker('setUTCDates', newDates);
            });

            var startDate = jQuery(this).datepicker('getDate');
            var oneDayFromStartDate = moment(startDate).add(1, 'days').toDate();
            
            bookingWidget.find('.arrival').datepicker('setDate', oneDayFromStartDate);

            jQuery('html, body').scrollTop(bookingWidget.offset().top);

        });

    });



    jQuery('.lcw_booking_widget').each(function(){
    
        var dates = jQuery(this).data('disableddates');

        jQuery(this).find('.lcw_daterange input.arrival').datepicker({
            format: 'yyyy-mm-dd',
            datesDisabled: dates,
            endDate: "+1y",
            startDate: new Date(),
            keyboardNavigation: false,
            autoclose: true,
            todayHighlight: true,
            disableTouchKeyboard: true,
			orientation: 'bottom auto'
        });

        jQuery(this).find('.lcw_daterange input.departure').datepicker({
            format: 'yyyy-mm-dd',
            datesDisabled: dates,
            endDate: "+1y",
            startDate: moment().add(1, 'days').toDate(),
            keyboardNavigation: false,
            autoclose: true,
            todayHighlight: true,
            disableTouchKeyboard: true,
			orientation: 'bottom auto'
        });


        jQuery(this).find('.lcw_daterange input.arrival').datepicker().on("changeDate", function () {
            var startDate = jQuery(this).datepicker('getDate');
            var oneDayFromStartDate = moment(startDate).add(1, 'days').toDate();
            jQuery(this).siblings('input.departure').datepicker('setStartDate', oneDayFromStartDate);
            jQuery(this).siblings('input.departure').datepicker('setDate', oneDayFromStartDate);
            jQuery(this).siblings('input.departure').removeAttr('disabled');
            jQuery(this).siblings('input.departure').datepicker('show');
        });
          
        jQuery(this).find('.lcw_daterange input.departure').datepicker().on("show", function () {
            var startDate = jQuery(this).siblings('.lcw_daterange input.arrival').datepicker('getDate');
            jQuery('.day.disabled').filter(function (index) {
              return jQuery(this).text() === moment(startDate).format('D');
            }).addClass('active');
        });


        jQuery(this).find('.lcw_form_button').click(function(){
            var error = '';
            
            var listingID = jQuery(this).closest('.lcw_booking_widget').data('listingid');
            var bookingUrl = jQuery(this).closest('.lcw_booking_widget').data('bookingurl');
            var roomID = jQuery(this).closest('.lcw_booking_widget').data('roomid');

            var checkIn = jQuery(this).closest('.lcw_booking_widget').find('.lcw_daterange input.arrival').val();
            var checkOut = jQuery(this).closest('.lcw_booking_widget').find('.lcw_daterange input.departure').val();
            var guests = jQuery(this).closest('.lcw_booking_widget').find('.lcw_daterange input.lcw_guests').val();

            var start = moment(checkIn);
            var end = moment(checkOut);

            console.log('Listing ID:' + listingID);
            console.log('Booking URL:' + bookingUrl);
            console.log('Room ID:' + roomID);

            console.log('Check in:' + checkIn);
            console.log('Check out:' + checkOut);
            console.log('Guests:' + guests);

            var minStays = jQuery(this).closest('.lcw_booking_widget').data('minstay');

            if((end.diff(start, "days") < minStays) && minStays != 1) {
                error += '<span class="error-notice">Please select '+minStays+' or more days.</span>';
            } 


            if(checkIn == '') {
                error += '<span class="error-notice">Check in date is required!</span>';
            }

            if(checkOut == '') {
                error += '<span class="error-notice">Check out date is required!</span>';
            }
            
            if(error == '') {
                var paymentGateway = bookingUrl+'/'+listingID+'/'+checkIn.replaceAll('-', '')+','+checkOut.replaceAll('-', '')+','+guests+'/'+roomID+'/-/pay';
                window.open(paymentGateway);
                // console.log(paymentGateway);
            } else {
                jQuery(this).closest('.lcw_booking_widget').find('.lcw_form_errors').html(error);
            }
        });

        
    });
        

});
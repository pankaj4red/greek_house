@extends ('customer')

@section ('title', 'Approve Design')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">APPROVE DESIGN</div>
        <div class="popup-body"  id="approve_design">
            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="row">
                <div class="col-md-12">
                    <p class="text-center">Once you approve design, we typically don't allow for changes.</p>
                    <p class="text-center">Are you sure you want to Approve Design?</p>
                </div>
            </div>
            <div class="action-row text-center">
                <a href="{{ $back }}" class="button-back btn btn-default back-btn">No</a>
                <button type="button" name="save" value="save_design" class="btn btn-primary" id="popup-ajax-button-design">
                    Yes
                </button>


            </div>
            {{ Form::close() }}
        </div>
        <div class="popup-body" id="payment_options" style="display: none">

            {{ Form::open(['id' => 'ajax-form']) }}
            <div class="ajax-messages"></div>
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="content" id="step1">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <label class="control-label">How do you want to collect sizes and payment?
                    </label>
                      <div>
                          <label class="radio-label">
                              {{ Form::radio('payment_type', 'Check', true) }}
                              <strong>Pay with Check</strong> - Submit Sizes on Message Board

                          </label>
                          <label class="radio-label">
                              {{ Form::radio('payment_type', 'Individual', true) }}
                              <strong>Share Payment Link</strong> - Everyone Submits Sizes and Pays on Their Own
                          </label>
                        <label class="radio-label">
                            {{ Form::radio('payment_type', 'Group', true) }}
                            <strong>Chapter Credit Card</strong> - Submit Sizes on Message Board or Through Payment Link
                        </label>


                      </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">When do you think you’ll have the sizes collected?</label>
                        {{ Form::text('collection_date', null, ['class' => 'form-control date', 'id' => 'close_date', 'placeholder' => 'Date']) }}
                    </div>

                </div>
            </div>
            <div class="action-row text-center">
                <button type="button" name="save" value="save" class="btn btn-primary" id="save-button">
                    Save
                </button>

            </div>
            </div>
            <div class="content" id="step2" style="display: none">
                <div class="row">
                    <div class="col-md-12">
                        <p class="text-center" id="approve_message1"></p>
                        {{ Form::hidden('approve_message_url', route('customer_block_popup', ['review_proofs', $campaign->id, 'approve_message']), ['id' => 'approve_message_url'])}}
                    </div>
                </div>
                <div class="action-row text-center">
                    <button type="button" name="sooner" value="sooner" class="btn btn-primary" id="popup-ajax-button-sooner">
                        I Need My Order Sooner
                    </button>
                    <button type="button" name="save" value="save_payment" class="btn btn-primary popup-ajax-button-ok">
                        OK
                    </button>

                </div>
            </div>

            <div class="content" id="step3" style="display: none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">When do you need these delivered by?</label>
                            {{ Form::text('scheduled_date', null, ['class' => 'form-control date', 'id' => 'scheduled_date', 'placeholder' => 'Date']) }}
                        </div>
                    <!--<div class="form-group">
                            <label class="control-label">What’s the soonest you’d be able to get sizes in by?
                            </label>
                            {{ Form::text('collection_date_revised', null, ['class' => 'form-control date', 'id' => 'collection_date_revised', 'placeholder' => 'Date']) }}
                            </div> -->
                    </div>
                </div>
                <div class="action-row text-center">
                    <button type="button" name="save" value="save_payment" class="btn btn-primary" id="due_date_ok_btn">
                        OK
                    </button>
                    {{ Form::hidden('delivery_type', "normal", ['id' => 'delivery_type'])}}

                </div>
            </div>
            <div class="content" id="step4" style="display: none">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div id="gaurantee_question">When do you need these delivered by?</div>
                             </div>

                    </div>
                </div>
                <div class="action-row text-center">

                    <button type="button" name="save" value="save_payment" class="btn btn-default" id="no_gaurantee_btn">
                        No, I need to pick a new Delivery Date
                    </button>
                    <button type="button" name="save" value="save_payment" class="btn btn-primary popup-ajax-button-ok">
                        Yes!
                    </button>
                    {{ Form::hidden('email_type', "", ['id' => 'email_type'])}}

                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>

    @if (!Request::ajax())
        {!! '</div>' !!}
    @endif
@endsection

@section ('ajax')
    <script>

        $("#save-button").click(function(){
            $(this).closest('form').find('.ajax-messages').empty();
            if($("#close_date").val() != '') {
                var that = this;
                var formData = $(this).closest('form').serialize();
                $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
                $(this).prop('disabled', true);
                var url = $("#approve_message_url").val();
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (data) {

                        if (data.success) {
                            $("#approve_message1").text(data.message1);

                            $("#step2").slideDown();
                            $("#step1").slideUp()
                        }
                    },
                    complete: function () {
                        $(that).find('.ajax-progress').remove();
                        $(that).prop('disabled', false);
                    }
                });

            }
            else{
                $(this).closest('form').find('.ajax-messages').empty();
                var errorText = $('<ul></ul>');
                errorText.append($('<li> Please select a date </li>'));
                var alert = $('<div class="alert alert-danger" role="alert"></div>');
                alert.append(errorText);
                $(this).closest('form').find('.ajax-messages').append(alert);
            }
        });
        $("#popup-ajax-button-sooner").click(function(){
            $(this).closest('form').find('.ajax-messages').empty();
            $("#step3").slideDown();
            $("#step2").slideUp()
            $("#delivery_type").val("urgent");
        });
        $("#popup-ajax-button-design").click(function (event) {
            $(this).closest('form').find('.ajax-messages').empty();
            $("#payment_options").slideDown();
            $("#approve_design").slideUp();

        });
        $(document).on('click', "#ok_payment", function (event) {
            parent.$.fancybox.close();
            parent.location.reload(true);
        });


      $(".popup-ajax-button-ok").click(function (event) {
           event.preventDefault();
           var formData = $(this).closest('form').serialize();
           $(this).prop('disabled', true);
           $(this).append('<div class="ajax-progress ajax-progress-throbber"><i class="glyphicon glyphicon-refresh glyphicon-spin"></i></div>');
           var that = this;
           var url = $(this).closest('form').attr('action');
           $.ajax({
               url: url,
               type: 'POST',
               data: formData,
               dataType: 'json',
               success: function (data) {

                   if (data.success) {

                       $(that).closest('form').find('.ajax-messages').empty();
                       if (data.successes) {
                           for (var i = 0; i < data.successes.length; i++) {
                               $('.ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[i] + '</div>'));
                           }
                       }
                       var html = '<p>'+data.message+'</p>';
                       $("#payment_options").html(html);

                   } else {
                       $(that).closest('form').find('.ajax-messages').empty();
                       var errorText = $('<ul></ul>');
                       if (data.errors) {
                           for (var index in data.errors) {
                               if (data.errors[index] instanceof Array) {
                                   data.errors[index].forEach(function (errorEntry, index2) {
                                       errorText.append($('<li>' + errorEntry + '</li>'));
                                   });
                               } else {
                                   data.errors[index].append($('<li>' + error + '</li>'));
                               }
                           }
                       }
                       var alert = $('<div class="alert alert-danger" role="alert"></div>');
                       alert.append(errorText);
                       $(that).closest('form').find('.ajax-messages').append(alert);
                       if (data.successes) {
                           for (i = 0; i < data.successes.length; i++) {
                               $('.ajax-messages').append($('<div class="alert alert-success" role="alert">' + data.successes[i] + '</div>'));
                           }
                       }
                   }
               },
               error: function (data) {
                   $(that).closest('form').find('.ajax-messages').empty();
                   $(that).closest('form').find('.ajax-messages').append($('<div class="alert alert-danger" role="alert">Server Internal Error</div>'));
               },
               complete: function () {
                   $(that).find('.ajax-progress').remove();
                   $(that).prop('disabled', false);
               }
           });
           return false;
       });
        var dateToday = new Date();
       $("#close_date").datepicker({
           inline: false,
           minDate: dateToday,

       });
       var min_delivery_date =  add_business_days_to_date(7);//new Date();
      // min_delivery_date.setDate(min_delivery_date.getDate() + 8);
       $("#scheduled_date").datepicker({
            inline: false,
            minDate: min_delivery_date,
            beforeShowDay: $.datepicker.noWeekends,
            onSelect: function(date){
             show_date_options(date);
               // $("#collection_date_revised").datepicker( "option", "maxDate", endDate );
            }
        });
       $("#step3").on('click', '#due_date_ok_btn', function(){
           var date = $("#scheduled_date").val();
           console.log(date);
           if(date != ''){
               show_date_options(date);
           }
           else{
               var alert = $('<div class="alert alert-danger" role="alert"></div>');
               alert.append('Please select date');
               $(this).closest('form').find('.ajax-messages').append(alert);
           }

       });
       function show_date_options(date){
           var selectedDate = new Date(date);
           console.log(date);
           var today = new Date();
           var days_for_order = workingDaysBetweenDates(today, selectedDate);//selectedDate.getTime() - today.getTime();
           console.log('second days count= '+days_for_order);
           var formatted_date = date;
           var label_text = '';
           if(days_for_order >= 12){
               var sizes_date = new Date(date);
               for(var i=0; i<10; i++){
                   sizes_date.setDate(sizes_date.getDate() - 1);
                    if(sizes_date.getDay() == 6 || sizes_date.getDay() == 0)
                        i--;
               }
                var formatted_size_date = getFormattedDate(sizes_date);//(sizes_date.getMonth() +1) +'/'+sizes_date.getDate()+'/'+sizes_date.getFullYear();
               label_text = 'In order to get your order <span class="control-label">delivered to you by '+formatted_date+', we need to get sizes by '+formatted_size_date+'</span>. Can you guarantee that sizes will be submitted by this date?'
               $("#step4 #email_type").val('help');
           }
           else{
               label_text = 'In order to get your order <span class="control-label">delivered to you by '+formatted_date+', we need to have sizes TODAY</span> and be responsible for all Rush Shipping Fees. Can guarantee this?';
               $("#step4 #email_type").val('urgent');
           }
           $("#step4 #gaurantee_question").html(label_text);
           $("#step3").hide();
           $("#step4").show();
       }
        $("#step4").on("click", "#no_gaurantee_btn", function(){
            $("#step3").show();
            $("#step4").hide();
        });
        $("#collection_date_revised").datepicker({
            inline: false,
            minDate: dateToday,
            beforeShowDay: $.datepicker.noWeekends
        });
        function getFormattedDate(date) {
            var year = date.getFullYear();

            var month = (1 + date.getMonth()).toString();
            month = month.length > 1 ? month : '0' + month;

            var day = date.getDate().toString();
            day = day.length > 1 ? day : '0' + day;

            return month + '/' + day + '/' + year;
        }
        function workingDaysBetweenDates(startDate, endDate) {
            if (endDate < startDate) {
                return 0;
            }
            // Calculate days between dates
            var millisecondsPerDay = 86400 * 1000; // Day in milliseconds
            startDate.setHours(0,0,0,1);  // Start just after midnight
            endDate.setHours(23,59,59,999);  // End just before midnight
            var diff = endDate - startDate;  // Milliseconds between datetime objects
            var days = Math.ceil(diff / millisecondsPerDay);

            // Subtract two weekend days for every week in between
            var weeks = Math.floor(days / 7);
            days -= weeks * 2;

            // Handle special cases
            var startDay = startDate.getDay();
            var endDay = endDate.getDay();

            // Remove weekend not previously removed.
            if (startDay - endDay > 1) {
                days -= 2;
            }
            // Remove start day if span starts on Sunday but ends before Saturday
            if (startDay == 0 && endDay != 6) {
                days--;
            }
            // Remove end day if span ends on Saturday but starts after Sunday
            if (endDay == 6 && startDay != 0) {
                days--;
            }
            return days;
        }
        function add_business_days_to_date(days){
            var today = new Date();
            for(var i=0; i<days; i++){
                today.setDate(today.getDate() + 1);
                if(today.getDay() == 0 ||today.getDay() == 6)
                    i--;
            }
            return today;
        }

    </script>
@append

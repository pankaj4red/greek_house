<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Order Status</span></h3>
    </div>
    <div class="panel-body">
        {!! Form::open(['url' => $blockUrl]) !!}
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    {!! Form::select('state', campaign_state_options(), $campaign->state, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" name="save" value="save" class="btn btn-info btn-sm">Save</button>
                <button type="submit" name="save_dashboard" value="save_dashboard" class="btn btn-success btn-sm">Save &
                    Go To Dashboard
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>

@section ('javascript')
    <script>
        $('.order_action').change(function (event) {
            if ($(this).val() === 'close') {
                $('.order-date').hide();
            } else {
                $('.order-date').show();
            }
        });
    </script>
    <script>
        $("#close-date").datepicker({
            inline: false
        });
    </script>
@append
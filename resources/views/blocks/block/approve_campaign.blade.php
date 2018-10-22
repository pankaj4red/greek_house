<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Campaign Review</span></h3>
    </div>
    <div class="panel-body">
        @if ($edit)
            <div class="row">
                <div class="col-md-12">
                    {{ Form::open(['url' => route('customer_block_popup', ['approve_campaign', $campaign->id, 'approve']), 'class' => 'form-inline']) }}
                    <button type="submit" name="save" value="save" class="btn btn-info btn-sm">Approve Campaign</button>
                    {{ Form::open(['url' => route('customer_block_popup', ['approve_campaign', $campaign->id, 'cancel']), 'class' => 'form-inline']) }}
                    <button type="submit" name="cancel" value="cancel" class="btn btn-danger btn-sm">Disapprove Campaign</button>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    </div>
</div>

<div class="card mb-3">
    <div class="card-header">
        Unclaimed Campaign
    </div>
    <div class="card-body">
        @if ($edit)
            <a class="btn btn-success" href="{{ route('dashboard::grab', [$campaign->id]) }}">Claim</a>
            <a class="btn btn-danger" href="javascript: void(0);" data-toggle="modal" data-target="#modal-reject-{{ $campaign->id }}">Reject</a>
            <div class="modal fade" id="modal-reject-{{ $campaign->id }}" tabindex="-1" role="dialog" aria-labelledby="#modal-reject-{{ $campaign->id }}Label" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="#modal-reject-{{ $campaign->id }}Label">New message</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{ Form::open(['url' => route('dashboard::reject', [$campaign->id])]) }}
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <p>Why are you rejecting this design?</p>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-12">
                                            {{ Form::select('reason', on_hold_rejected_by_designer_reason_options(['' => 'Select a reason']), null, ['id' => 'reason_' . $campaign->id, 'class' => 'form-control']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-right">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Reject</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
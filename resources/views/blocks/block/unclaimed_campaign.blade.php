<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Unclaimed Campaign</span>
        </h3>
    </div>
    <div class="panel-body">
        @if ($edit)
            <div class="row">
                <div class="col-md-12">
                    <a class="btn btn-success" href="{{ route('dashboard::grab', [$campaign->id]) }}">Claim</a>
                    <a class="btn btn-danger" href="javascript: void(0);" data-toggle="modal" data-target="#modal-reject-{{ $campaign->id }}">Reject</a>
                    <div class="modal fade modal-override" id="modal-reject-{{ $campaign->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Reason for Rejecting Campaign</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="box">
                                        {{ Form::open(['url' => route('dashboard::reject', [$campaign->id])]) }}
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <p>Why are you rejecting this design?</p>
                                            </div>
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        {{ Form::select('reason', on_hold_rejected_by_designer_reason_options(['' => 'Select a reason']), null, ['id' => 'reason_' . $campaign->id, 'class' => 'form-control']) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="submit" class="btn btn-danger pull-right" id="reject_{{ $campaign->id }}">Reject</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{ Form::close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


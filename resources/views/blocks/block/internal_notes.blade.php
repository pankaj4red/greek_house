@if ($campaign->internal_notes->count() > 0)
    <div class="panel panel-default panel-box">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Internal Notes (Support)</span>
            </h3>
        </div>
        <div class="panel-body">
            @foreach ($campaign->internal_notes as $note)
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! process_text($note->content) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif


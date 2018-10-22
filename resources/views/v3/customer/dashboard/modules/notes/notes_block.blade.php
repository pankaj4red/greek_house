<div class="card mb-3">
    <div class="card-header">
        Designer & Support Notes
        <a class="" data-toggle="collapse" href="#notes" aria-expanded="true" aria-controls="test-block">
            <img class="pull-right collapse-icon mt-2" src="{{ static_asset('images/arrow-collapse.png') }}"/>
        </a>
    </div>
    <div class="card-body collapse show" id="notes">
        @if ($edit)
            {{ Form::open(['url' => $blockUrl]) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::textarea('notes', $campaign->notes, ['class' => 'form-control', 'rows' => 13]) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <button type="submit" name="notes_button" value="save" class="btn btn-info pull-right">Save</button>
                </div>
            </div>
            {{ Form::close() }}
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {!! process_text($campaign->notes) !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

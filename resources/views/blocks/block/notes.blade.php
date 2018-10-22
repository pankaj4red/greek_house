<?php
$img = '';
$class = '';
if (! isset($collapse) || !$collapse) {
    $class = '_support';
    $img = '<img src="' . static_asset('images/wizard/double-down-arrow.png') . '">';
}
?>
<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title" id="notes_heading{{$class}}"><i class="icon icon-status"></i>
            <span class="icon-text">Designer & Support Notes {!! $img !!}</span>
        </h3>
    </div>
    <div class="panel-body collapse-content" id="collapse-content-notes{{$class}}">
        @if ($edit)
            {{ Form::model($campaign, ['url' => $blockUrl]) }}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        {{ Form::textarea('notes', null, ['class' => 'form-control', 'rows' => 13]) }}
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
@section ('javascript')
    <script>
        $("#notes_heading_support").click(function () {
            $content = $("#collapse-content-notes_support");
            $content.slideToggle(500, function () {

            });
        });
    </script>
@append


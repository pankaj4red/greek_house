<div class="image-entry-container" data-id="{{ $type . '_' . $typeId }}">
    <div class="image-entry pull-left">
        <img src="{{ $url }}" class="img-rounded"/>
    </div>
    <div class="image-information pull-left margin-left" data-type="{{ $type }}">
        <div class="caption">
            <h4>{{ $type }}</h4>
            @if (isset($enable) && $enable)
                {{ Form::checkbox('enable', 'enabled', $enableState, ['data-type' => 'enable', 'data-toggle' => 'toggle', 'data-on' => 'Enabled', 'data-off' => 'Disabled', 'data-size' => 'small', 'data-onstyle' => 'success']) }}
            @endif
            @if (isset($addRemove) && $addRemove)
                {{ Form::checkbox('add', 'added', $addRemoveState, ['data-type' => 'add', 'data-toggle' => 'toggle', 'data-on' => 'Added', 'data-off' => 'Click to Add', 'data-size' => 'small', 'data-onstyle' => 'success']) }}
            @endif
            @if (isset($remove) && $remove)
                {{ Form::button('Remove', ['data-type' => 'remove', 'class' => 'btn btn-sm btn-danger']) }}
            @endif
            @if (isset($removeUpload) && $removeUpload)
                {{ Form::button('Remove', ['data-type' => 'upload', 'class' => 'btn btn-sm btn-danger']) }}
            @endif
        </div>
    </div>
</div>


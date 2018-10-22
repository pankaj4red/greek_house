<div class="file-wrapper">
    <div class="file-entry {{ ! isset($fieldData['url']) ? 'hidden-override' : '' }}">
        @if (isset($fieldData['url']))
            @if (! is_image($fieldData['filename']))
                <div class="file-entry-file">
                    <a href="{{ $fieldData['url'] }}" target="_blank"
                       class="non-image-file">{{ $fieldData['filename'] }}</a>
                </div>
            @else
                <div class="file-entry-image">
                    <img src="{{ $fieldData['url'] }}"/>
                </div>
            @endif
        @endif
        <input type="hidden" value="{{ isset($fieldData['url']) ? $fieldData['url'] : '' }}" name="{{ $fieldName }}_url"/>
        <input type="hidden" value="{{ isset($fieldData['filename']) ? $fieldData['filename'] : '' }}" name="{{ $fieldName }}_filename"/>
        <input type="hidden" value="{{ isset($fieldData['id']) ? $fieldData['id'] : '' }}" name="{{ $fieldName }}_id"/>
        <input type="hidden" value="existing" name="{{ $fieldName }}_action"/>
        @if (isset($fieldData['url']))
            <a href="#" class="btn btn-danger file-remove" data-target="{{ $fieldName }}">Remove</a>
        @endif
    </div>
    <div class="filepicker-file">
        <a href="#" class="filepicker" data-type="any" id="{{ $fieldName }}">Browse</a>
    </div>
</div>
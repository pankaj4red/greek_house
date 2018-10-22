<div class="file-wrapper" style="{{ isset($label) ? 'margin-top: 20px; margin-bottom: 20px;' : '' }}">
    @if (isset($label))
        <label style="position: absolute; top: -26px; left: 0;">{{ $label }}</label>
    @endif
    <div class="file-entry {{ ! isset($fieldData['url']) ? 'hidden-override' : '' }}">
        @if (isset($fieldData['url']) && $fieldType == 'image')
            <div class="file-entry-image size-auto">
                <img src="{{ $fieldData['url'] }}"/>
                <span>{{ $fieldData['filename'] }}</span>
            </div>
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
        <a href="#" class="filepicker" id="{{ $fieldName }}">Browse</a>
    </div>
</div>

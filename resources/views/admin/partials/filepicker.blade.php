<div class="filepicker-entry {{ isset($class) && $class ? $class : 'file-default' }}">
    <div class="filepicker-information {{ ! isset($fieldData['url']) || $fieldData['url'] == null ? 'hidden-override' : '' }}">
        @if (isset($fieldData['url']) && $fieldData['url'])
            @if (! is_image($fieldData['filename']))
                <div class="filepicker-entry-content filepicker-file-wrapper">
                    <a href="{{ $fieldData['url'] }}" target="_blank"
                       class="filepicker-file">{{ $fieldData['filename'] }}</a>
                </div>
            @else
                <div class="filepicker-entry-content filepicker-image-wrapper">
                    <img class="filepicker-image" src="{{ $fieldData['url'] }}"/>
                </div>
            @endif
        @endif
        <input type="hidden" value="{{ isset($fieldData['url']) && $fieldData['url']? $fieldData['url'] : '' }}" name="{{ $fieldName }}_url"/>
        <input type="hidden" value="{{ isset($fieldData['filename']) && $fieldData['filename']? $fieldData['filename'] : '' }}" name="{{ $fieldName }}_filename"/>
        <input type="hidden" value="{{ isset($fieldData['id']) && $fieldData['id'] ? $fieldData['id'] : '' }}" name="{{ $fieldName }}_id"/>
        <input type="hidden" value="existing" name="{{ $fieldName }}_action"/>
        @if (isset($fieldData['url']) && $fieldData['url'])
            <div class="filepicker-remove-wrapper">
                <a href="#" class="btn btn-danger filepicker-remove" data-target="{{ $fieldName }}">Remove</a>
            </div>
        @endif
    </div>
    <div class="filepicker-browse-wrapper">
        <a href="#" class="filepicker-browse filepicker" data-type="{{ isset($type) && $type ? $type : 'any' }}" id="{{ $fieldName }}">Browse</a>
    </div>
</div>

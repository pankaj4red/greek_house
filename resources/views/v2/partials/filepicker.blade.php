<div class="filepicker-entry {{ isset($class) ? $class : 'file-default' }}">
    <div class="filepicker-information {{ ! isset($url) ? 'hidden-override' : '' }}">
        @if (isset($url) && $url)
            @if (! is_image($filename))
                <div class="filepicker-entry-content filepicker-file-wrapper">
                    <a href="{{ $url }}" target="_blank"
                       class="filepicker-file">{{ $filename }}</a>
                </div>
            @else
                <div class="filepicker-entry-content filepicker-image-wrapper">
                    <img class="filepicker-image" src="{{ $url }}"/>
                </div>
            @endif
        @endif
        <input type="hidden" value="{{ isset($url) ? $url : '' }}" name="{{ $fieldName }}_url"/>
        <input type="hidden" value="{{ isset($filename) ? $filename : '' }}" name="{{ $fieldName }}_filename"/>
        <input type="hidden" value="{{ isset($id) ? $id : '' }}" name="{{ $fieldName }}_id"/>
        <input type="hidden" value="existing" name="{{ $fieldName }}_action"/>
        @if (isset($url) && $url)
            <div class="filepicker-remove-wrapper">
                <a href="#" class="btn btn-danger filepicker-remove" data-target="{{ $fieldName }}">Remove</a>
            </div>
        @endif
    </div>
    <div class="filepicker-browse-wrapper">
        <a href="#" class="filepicker-browse filepicker" data-type="{{ isset($type) ? $type : 'any' }}" id="{{ $fieldName }}">Browse</a>
    </div>
</div>

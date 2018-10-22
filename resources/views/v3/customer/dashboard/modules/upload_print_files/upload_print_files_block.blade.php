<div class="card mb-3">
    <div class="card-header">
        Upload Print Files & Order Forms(s)
    </div>
    <div class="card-body">
        @if ($edit)
            <div class="mb-3">
                {{ Form::open(['url' => $blockUrl, 'files' => true, 'class' => 'd-flex align-items-stretch']) }}
                <label class="gh-file mr-3">
                    <input type="file" class="gh-file-input" id="upload-print-file" name="print_file"/>
                    <label class="gh-file-label" for="upload-print-file">Choose file</label>
                </label>
                <button type="submit" class="btn btn-info btn-sm">Upload</button>
                {{ Form::close() }}
            </div>
        @endif
        <div class="mb-3">
            @if (count($campaign->getCurrentArtwork()->print_files) > 0)
                @foreach ($campaign->getCurrentArtwork()->print_files as $fileEntry)
                    <div class="badge-file">
                        <a href="{{ route('system::file', [$fileEntry->file->id]) }}">{{ $fileEntry->file->name }}</a>
                        <span>{{ file_size($fileEntry->file->size) }}</span>
                        @if ($edit)
                            {{ Form::open(['route' => ['customer_module_popup', 'upload_print_files', $campaign->id, 'delete']]) }}
                            {{ Form::hidden('file_id', $fileEntry->file_id) }}
                            <button type="submit" data-confirm="Are you sure you want to delete this file?"></button>
                            {{ Form::close() }}
                        @endif
                    </div>
                @endforeach
            @else
                No print files were uploaded.
            @endif
        </div>
        <div class="mb-3">
            @if ($campaign->bag_tag_id)
                <div class="badge-file">
                    <a href="{{ route('system::file', [$campaign->bag_tag_id]) }}">Bag & Tag</a>
                    <span>{{ file_size($campaign->bagTag->size) }}</span>
                </div>
            @else
                <div class="badge-file">
                    <a href="{{ route('report::campaign_sales', [$campaign->id]) }}">Order List</a>
                </div>
            @endif

            <div class="badge-file">
                <a href="{{ route('report::campaign_shipping_file', [$campaign->id]) }}">Shipping File CSV</a>
            </div>

            <div class="badge-file">
                <a href="{{ route('report::campaign_shipping_pdf', [$campaign->id]) }}">Shipping File PDF</a>
            </div>
        </div>
    </div>
</div>

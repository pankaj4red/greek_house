<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-image"></i><span class="icon-text">Upload Print Files & Order Forms(s)</span>
        </h3>
    </div>
    <div class="panel-body">
        @if ($evaluate)
            <button class="btn btn-danger ajax-popup order-detail-page"
                    href="{{ route('customer_block_popup', ['upload_print_files', $campaign->id, 'artwork_bad']) }}">
                ARTWORK - BAD
            </button>
            <button class="btn btn-primary ajax-popup order-detail-page"
                    href="{{ route('customer_block_popup', ['upload_print_files', $campaign->id, 'artwork_good']) }}">
                ARTWORK - GOOD
            </button>
        @endif
        @if ($edit)
            <div class="upload-print-row">
                {{ Form::open(['url' => $blockUrl, 'files' => true]) }}
                <span class="file is-active">
                        <input type="file" name="print_file"/>
                        <span aria-hidden="true">Choose a File</span>
                    </span>
                <button type="submit" class="btn btn-info upload-image">Upload</button>
                {{ Form::close() }}
            </div>
        @endif
        <div class="upload-print-list-wrapper">
            @if (count($campaign->getCurrentArtwork()->print_files) > 0)
                <ul class="upload-print-list">
                    @foreach ($campaign->getCurrentArtwork()->print_files as $fileEntry)
                        <li>
                            @if ($edit)
                                {{ Form::open(['route' => ['customer_block_popup', 'upload_print_files', $campaign->id, 'delete']]) }}
                                {{ Form::hidden('file_id', $fileEntry->file->id) }}
                                <p>
                                    <a href="{{ route('system::file', [$fileEntry->file->id]) }}">{{ $fileEntry->file->name }}</a>{{ file_size($fileEntry->file->size) }}
                                </p>
                                <button class="delete-print"></button>
                                {{ Form::close() }}
                            @else
                                <p>
                                    <a href="{{ route('system::file', [$fileEntry->file->id]) }}">{{ $fileEntry->file->name }}</a>{{ file_size($fileEntry->file->size) }}
                                </p>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                No print files were uploaded.
            @endif
            <ul class="upload-print-list">
                <li>
                    @if ($campaign->bag_tag_id)
                        <p><a href="{{ route('system::file', [$campaign->bag_tag_id]) }}">Bag &
                                Tag</a>{{ file_size($campaign->bagTag->size) }}</p>
                    @else
                        <p><a href="{{ route('report::campaign_sales', [$campaign->id]) }}">Order List</a></p>
                    @endif
                </li>
                @if ($shipping)
                    <li>
                        <p><a href="{{ route('report::campaign_shipping_file', [$campaign->id]) }}">Shipping File CSV</a></p>
                    </li>
                    <li>
                        <p><a href="{{ route('report::campaign_shipping_pdf', [$campaign->id]) }}">Shipping File PDF</a></p>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>

@section ('javascript')
    <script>
        $('.delete-print').click(function (event) {
            var result = confirm("Are you sure you want to delete this file?");
            if (result === false) {
                event.preventDefault();
                return false;
            }
        });
        $('.file.is-active > input').change(function (event) {
            if (this.value) {
                $(this).closest('.file').find('span').text(this.value.replace(/^.*\\/, ''));
            }
        });
    </script>
@append
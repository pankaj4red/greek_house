<div class="card">
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-left">Designer</th>
                        <th class="text-left">Estimated Qty</th>
                        <th class="text-left">University</th>
                        <th class="text-left">Chapter</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-lg color-blue">{{ $campaign->artwork_request->designer ? $campaign->artwork_request->designer->getFullName() : 'N/A' }}</td>
                        <td class="text-lg color-blue">{{ $campaign->estimated_quantity }}</td>
                        <td class="text-lg color-blue">{{ $campaign->contact_school ? $campaign->contact_school : '' }}</td>
                        <td class="text-lg color-blue">{{ $campaign->contact_chapter ? $campaign->contact_chapter : '' }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </li>
        @if ($campaign->artwork_request->print_front)
            <li class="list-group-item bg-gray">
                <span class="text-uppercase">Front of Shirt</span>
                <span class="text-uppercase pull-right"># of colors: {{ $campaign->artwork_request->print_front_colors }}</span>
            </li>
            <li class="list-group-item">
                <p>{!! process_text($campaign->artwork_request->print_front_description) !!}</p>
            </li>
        @endif
        @if ($campaign->artwork_request->print_pocket)
            <li class="list-group-item bg-gray">
                <span class="text-uppercase">Pocket of Shirt</span>
                <span class="text-uppercase pull-right"># of colors: {{ $campaign->artwork_request->print_pocket_colors }}</span>
            </li>
            <li class="list-group-item">
                <p>{!! process_text($campaign->artwork_request->print_pocket_description) !!}</p>
            </li>
        @endif
        @if ($campaign->artwork_request->print_back)
            <li class="list-group-item bg-gray">
                <span class="text-uppercase">Back of Shirt</span>
                <span class="text-uppercase pull-right"># of colors: {{ $campaign->artwork_request->print_back_colors }}</span>
            </li>
            <li class="list-group-item">
                <p>{!! process_text($campaign->artwork_request->print_back_description) !!}</p>
            </li>
        @endif
        @if ($campaign->artwork_request->print_sleeve)
            <li class="list-group-item bg-gray">
                <span class="text-uppercase">Sleeves of Shirt</span>
                <span class="text-uppercase pull-right"># of colors: {{ $campaign->artwork_request->print_sleeve_colors }}</span>
            </li>
            <li class="list-group-item">
                <p>
                    Preferred:
                    {{ $campaign->artwork_request->print_sleeve_preferred == 'left' ? 'Left' : '' }}
                    {{ $campaign->artwork_request->print_sleeve_preferred == 'right' ? 'Right':'' }}
                    {{ $campaign->artwork_request->print_sleeve_preferred == 'both' ? 'Both' : '' }}
                    <br/>
                    Sleeve{{ $campaign->artwork_request->print_sleeve_preferred == 'both' ? 's' : '' }} of Shirt </p>
                <p>{!! process_text($campaign->artwork_request->print_sleeve_description) !!}</p>
            </li>
        @endif
        <li class="list-group-item bg-gray">
            <span class="text-uppercase">References</span>
        </li>
        <li class="list-group-item">
            <div class="row">
                @foreach ($campaign->getCurrentArtwork()->images as $imageEntry)
                    <div class="col-12 col-md-4 mb-3">
                        <a href="{{ route('system::file', [$imageEntry->file->id]) }}" target="_blank">
                            <div class="image-background w-100 wh-equal image-effect" style="background-image: url({{ route('system::file', [$imageEntry->file->id]) }})"></div>
                        </a>
                    </div>
                @endforeach
            </div>
        </li>
    </ul>
</div>

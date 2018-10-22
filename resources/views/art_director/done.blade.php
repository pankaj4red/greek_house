@extends ('customer')

@section ('title', 'Art Director Dashboard')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Art Director Dashboard</span>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('art_director::designer') }}" class="btn btn-default add-new-btn"
                   id="account-manager-accounts">
                    <span>Designers</span></a>
            </div>
            <div class="pull-right new-order">
                <a role="button" href="{{ route('art_director::index') }}" class="btn btn-default add-new-btn"
                   id="account-manager-accounts">
                    <span>Campaigns</span></a>
            </div>
        </div>
    </div>
    <div class="container">
        @if (messages_exist())
            {!! messages_output() !!}
        @endif
        <div class="row">
            <div class="col-md-12">
                <table class="view_links_table">
                    <tbody>
                    <tr class="view_links_tr">
                        <td><a href="{{ route('art_director::index') }}">All</a></td>
                        <td><a href="{{ route('art_director::unclaimed') }}">Unclaimed Campaigns</a></td>
                        <td><a href="{{ route('art_director::awaiting_for_designer') }}">Awaiting for Designer</a></td>
                        <td><a href="{{ route('art_director::awaiting_for_customer') }}">Awaiting for Customer</a></td>
                        <td><a href="{{ route('art_director::upload_files') }}">Upload Files</a></td>
                        <td><a href="{{ route('art_director::done') }}" class="active">Complete</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h4>Complete</h4>
                </div>
                <div class="row">
                    <div class="col-md-3 margin-bottom">
                        <label for="filter-embellishment" class="sr-only">Embellishments</label>
                        <select id="filter-embellishment" class="form-control">
                            <option value="">Show all embellishments</option>
                            <option value="embroidery" {!! Request::get('embellishment') == 'embroidery' ? 'selected' : '' !!}>
                                Show only embroidery
                            </option>
                            <option value="screen" {!! Request::get('embellishment') == 'screen' ? 'selected' : '' !!}>
                                Show only screen print
                            </option>
                        </select>
                    </div>
                </div>
                <div class="panel panel-default panel-box">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed" id="done">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Campaign Name</th>
                                    <th>Designer</th>
                                    <th>State</th>
                                    <th>C. Design Waiting</th>
                                    <th>C. Revision Waiting</th>
                                    <th>Designer Waiting</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($done as $campaign)
                                    <tr>
                                        <td>{{ $campaign->id }}</td>
                                        <td>
                                            <a href="{{ route('dashboard::details', [$campaign->id]) }}">{{ $campaign->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ $campaign->artwork_request->designer ? route('art_director::designer', [$campaign->artwork_request->designer_id]) : '#' }}">{{ $campaign->artwork_request->designer ? $campaign->artwork_request->designer->getFullName() : '-' }}</a>
                                        </td>
                                        <td>{{ campaign_state_caption($campaign->state) }}</td>
                                        <td>{{ time_count($campaign->getCustomerNewOrderWaitingTime()) }}</td>
                                        <td>{{ time_count($campaign->getCustomerRevisionWaitingTime()) }}</td>
                                        <td>{{ time_count($campaign->getDesignerWaitingTime()) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section ('javascript')
    <script>
        $('#filter-embellishment').change(function () {
            window.location = '{{ route('art_director::done') }}?embellishment=' + $(this).val();
        });
    </script>
@append

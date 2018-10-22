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
                        <td><a href="{{ route('art_director::index') }}" class="active">All</a></td>
                        <td><a href="{{ route('art_director::unclaimed') }}">Unclaimed Campaigns</a></td>
                        <td><a href="{{ route('art_director::awaiting_for_designer') }}">Awaiting for Designer</a></td>
                        <td><a href="{{ route('art_director::awaiting_for_customer') }}">Awaiting for Customer</a></td>
                        <td><a href="{{ route('art_director::upload_files') }}">Upload Files</a></td>
                        <td><a href="{{ route('art_director::done') }}">Complete</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h4>Unclaimed Campaigns</h4>
                </div>
                <div class="panel panel-default panel-box">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed" id="unclaimed">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Campaign Name</th>
                                    <th>Customer Waiting Time</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($unclaimed as $campaign)
                                    <tr>
                                        <td>{{ $campaign->id }}</td>
                                        <td>
                                            <a href="{{ route('dashboard::details', [$campaign->id]) }}">{{ $campaign->name }}</a>
                                        </td>
                                        <td>{{ time_count($campaign->getCustomerWaitingTime()) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h4>Awaiting for Designer</h4>
                </div>
                <div class="panel panel-default panel-box">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed" id="designer">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Campaign Name</th>
                                    <th>Designer</th>
                                    <th>State</th>
                                    <th>C. Design Waiting</th>
                                    <th>C. Revision Waiting</th>
                                    <th>Designer Waiting</th>
                                    <th>Countdown</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($designer as $campaign)
                                    <tr class="{{ countdown_class($campaign->getCountdownTime()) }}">
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
                                        <td>{{ time_count($campaign->getCountdownTime()) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h4>Awaiting for Customer</h4>
                </div>
                <div class="panel panel-default panel-box">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed" id="customer">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Campaign Name</th>
                                    <th>Designer</th>
                                    <th>State</th>
                                    <th>C. Design Waiting</th>
                                    <th>C. Revision Waiting</th>
                                    <th>Designer Waiting</th>
                                    <th>Time in State</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($customer as $campaign)
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
                                        <td>{{ time_count($campaign->getCurrentTimeInState()) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h4>Upload Files</h4>
                </div>
                <div class="panel panel-default panel-box">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-condensed" id="files">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Campaign Name</th>
                                    <th>Designer</th>
                                    <th>State</th>
                                    <th>Approved At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($uploadFiles as $campaign)
                                    <tr>
                                        <td>{{ $campaign->id }}</td>
                                        <td>
                                            <a href="{{ route('dashboard::details', [$campaign->id]) }}">{{ $campaign->name }}</a>
                                        </td>
                                        <td>
                                            <a href="{{ $campaign->artwork_request->designer ? route('art_director::designer', [$campaign->artwork_request->designer_id]) : '#' }}">{{ $campaign->artwork_request->designer ? $campaign->artwork_request->designer->getFullName() : '-' }}</a>
                                        </td>
                                        <td>{{ campaign_state_caption($campaign->state) }}</td>
                                        <td>{{ date('Y-m-d H:i:s', strtotime($campaign->awaiting_quote_at)) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="title">
                    <h4>Complete</h4>
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

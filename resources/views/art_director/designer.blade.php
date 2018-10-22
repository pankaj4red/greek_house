@extends ('customer')

@section ('title', 'Art Director Dashboard')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    <div class="page-header cancel-header-margin">
        <div class="container">
            <span class="pull-left page-title">Designer Overview</span>
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
        @if ($designer)
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>{{ $designer->getFullName() }}'s Information</h4>
                    </div>
                    <div class="panel panel-default panel-minimalistic">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="icon icon-user"></i><span
                                        class="icon-text">Designer Info</span></h3>
                            <a href="{{ route('art_director::log_in_as', [$designer->id]) }}"
                               class="profile-edit order-detail-page">Log in as user</a>
                        </div>
                        <div class="panel-body">
                            <div class="customer-information">
                                <div class="form-group">
                                    <label>Id:</label>
                                    {{ $designer->id }}
                                </div>
                                <div class="form-group">
                                    <label>Name:</label>
                                    {{ $designer->getFullName() }}
                                </div>
                                <div class="form-group">
                                    <label>Email:</label>
                                    {{ $designer->email }}
                                </div>
                                <div class="form-group">
                                    <label>Phone:</label>
                                    {{ get_phone($designer->phone) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>{{ $designer->getFullName() }}'s Campaigns</h4>
                    </div>
                    <div class="panel panel-default panel-box">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed" id="campaigns">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Campaign Name</th>
                                        <th>State</th>
                                        <th>C. Design Waiting</th>
                                        <th>C. Revision Waiting</th>
                                        <th>Designer Waiting</th>
                                        <th>Time in State</th>
                                        <th>Created</th>
                                        <th>Revision Count</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($designerCampaigns as $campaign)
                                        <tr
                                                @if (in_array($campaign->state, ['awaiting_design', 'revision_requested']))
                                                class="{{ countdown_class($campaign->getCountdownTime()) }}"
                                                @endif
                                        >
                                            <td>{{ $campaign->id }}</td>
                                            <td>
                                                <a href="{{ route('dashboard::details', [$campaign->id]) }}">{{ $campaign->name }}</a>
                                            </td>
                                            <td>{{ campaign_state_caption($campaign->state) }}</td>
                                            <td>{{ time_count($campaign->getCustomerNewOrderWaitingTime()) }}</td>
                                            <td>{{ time_count($campaign->getCustomerRevisionWaitingTime()) }}</td>
                                            <td>{{ time_count($campaign->getDesignerWaitingTime()) }}</td>
                                            <td>{{ time_count($campaign->getCurrentTimeInState()) }}</td>
                                            <td>{{ date('Y-m-d', strtotime($campaign->created_at)) }}</td>
                                            <td class="text-right">{{ $campaign->revision_count }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>Designers</h4>
                    </div>
                    <div class="panel panel-default panel-box">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-condensed" id="designers">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($designers as $designer)
                                        <tr>
                                            <td>{{ $designer->id }}</td>
                                            <td>
                                                <a href="{{ route('art_director::designer', [$designer->id]) }}">{{ $designer->getFullName() }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

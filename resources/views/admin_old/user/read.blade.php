@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">User Details
                {!! Form::open(['route' => ['admin::user::loginas', $user->id]]) !!}
                <a href="{{ route('admin::user::update', [$user->id]) }}" class="btn btn-default">Edit</a>
                <button type="submit" class="btn btn-info">Login As</button>
                {!! Form::close() !!}
            </h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Contact Information
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Username</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->username }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">First Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->first_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Last Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->last_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Email</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Phone</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->phone }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">School</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->school }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Chapter</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->chapter }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Graduation Year</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->graduation_year }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Type</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->type->caption }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">School Year<br/>(Campus Ambassador)</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ school_year_text($user->school_year) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Venmo Username<br/>(Campus Ambassador)</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->venmo_username }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Activation Needed</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->activation_code?'Yes':'No' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Active</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $user->active?'Yes':'No' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Account Manager</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($user->account_manager_id)
                                        <a href="{{ route('admin::user::read', [$user->account_manager_id]) }}">{{ $user->account_manager->getFullName() }}</a>
                                </p>
                                @else
                                    N/A
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator Status</label>
                            </div>
                            <div class="col-sm-9">
                                {{ $user->decorator_status }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator Screenprint Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                {{ $user->decorator_screenprint_enabled ? 'Yes' : 'No' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator Embroidery Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                {{ $user->decorator_embroidery_enabled ? 'Yes' : 'No' }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">On Hold State Protection</label>
                            </div>
                            <div class="col-sm-9">
                                {{ $user->on_hold_state }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Avatar</label>
                            </div>
                            <div class="col-sm-9">
                                @if ($user->avatar_id)
                                    <img src="{{ route('system::image', [$user->avatar_id]) }}"/>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Addresses
                    <a href="{{ route('admin::address::create', [$user->id]) }}" class="btn btn-default">Create</a>
                </div>
                <div class="panel-body">
                    @if ($user->addresses)
                        @foreach ($user->addresses as $address)
                            <div class="panel {{ $user->address_id == $address->id?'panel-primary':'panel-default' }}">
                                <div class="panel-heading">
                                    @if ($user->address_id == $address->id)
                                        Shipping
                                    @endif
                                    Address
                                    <a href="{{ route('admin::address::update', [$address->id]) }}"
                                       class="btn btn-default">Edit</a>
                                    @if ($user->address_id != $address->id)
                                        <a href="{{ route('admin::address::make_shipping', [$address->id]) }}"
                                           class="btn btn-default">Make Shipping</a>
                                    @endif
                                </div>
                                <div class="panel-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Name</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $address->name }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Line 1</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $address->line1 }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Line 2</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $address->line2 }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">City</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $address->city }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">State</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $address->state }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Zip Code</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $address->zip_code }}</p>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                <label class="control-label">Country</label>
                                            </div>
                                            <div class="col-sm-9">
                                                <p class="form-control-static">{{ $address->country }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No addresses
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Statistics
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Placed Campaigns</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getPlacedCampaigns()) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Successful Campaigns</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getSuccessfulCampaigns()) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Cancelled Campaigns</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getCancelledCampaigns()) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Total Design Hours</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ $user->getTotalDesignHours() }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Avg. Design Hours / Campaign</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ $user->getAverageDesignHours() }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Avg. Revisions / Campaign</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getAverageRevisions()) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Total Revenue</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ money($user->getTotalRevenue()) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Avg. Total Sale (Revenue) / Campaign</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ money($user->getAverageRevenue()) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Total Quantity Ordered</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getTotalQuantityOrdered()) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label">Avg. Quantity / Campaign</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getAverageQuantityOrdered()) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label"># of Referrals Submitted</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getReferralsSubmitted()) }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label"># of Referrals w/ Successful Orders</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="form-control-static">{{ number($user->getReferralsSuccess()) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Members
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Type</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($user->members as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::user::read', [$entry->id]) }}">{{ $entry->getFullName() }}</a>
                                    </td>
                                    <td>
                                        {{ $entry->email }}
                                    </td>
                                    <td>
                                        {{ get_phone($entry->phone) ? get_phone($entry->phone) : $entry->phone }}
                                    </td>
                                    <td>{{ $entry->type->caption }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Campaigns
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Client</th>
                                <th>Designer</th>
                                <th>Last Updated</th>
                                <th>State</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($user->campaigns as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::campaign::read', [$entry->id]) }}">{{ $entry->name }}</a>
                                    </td>
                                    <td>
                                        @if ($entry->user)
                                            <a href="{{ route('admin::user::read', [$entry->user->id]) }}">{{ $entry->user->getFullName() }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if ($entry->artwork_request->designer)
                                            <a href="{{ route('admin::user::read', [$entry->artwork_request->designer->id]) }}">{{ $entry->artwork_request->designer->getFullName() }}</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ date('m/d/Y h:i a', strtotime($entry->updated_at)) }}</td>
                                    <td>{{ campaign_state_caption($entry->state) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Orders
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive table-bordered margin-bottom">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Order</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Last Updated</th>
                                <th>State</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($user->orders as $entry)
                                <tr>
                                    <td>{{ $entry->id }}</td>
                                    <td>
                                        <a href="{{ route('admin::campaign::read', [$entry->campaign->id]) }}">{{ $entry->campaign->name }}</a>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin::order::read', [$entry->id]) }}">{{ $entry->payment_type }}
                                            Order {{ ($entry->payment_type=='individual')?' / ' . $entry->shipping_type . ' Shipping':'' }}</a>
                                    </td>
                                    <td>${{ number_format($entry->total, 2) }}</td>
                                    <td>{{ date('m/d/Y h:i a', strtotime($entry->updated_at)) }}</td>
                                    <td>{{ $entry->state }}</td>
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
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::user::list') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
@endsection
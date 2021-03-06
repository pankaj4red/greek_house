@extends ('customer')

@section ('title', 'Customer Information')

@section ('messages')
    <div class="nope"></div>
@endsection

@section ('content')
    @if (!Request::ajax())
        {!! '<div class="container">' !!}
    @endif
    <div class="popup">
        <div class="popup-title">USER INFORMATION</div>
        <div class="popup-body">
            @if (messages_exist())
                {!! messages_output() !!}
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="title">
                        <h4>Contact Information</h4>
                    </div>
                    <div class="panel panel-default panel-box">
                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">Username</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->username }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">First Name</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->first_name }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">Last Name</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->last_name }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">Email</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->email }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">Phone</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->phone }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">School</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->school }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">Chapter</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->chapter }}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">Type</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="form-control-static">{{ $user->type->caption }}</p>
                                    </div>
                                </div>
                                @if ($user->account_manager_id)
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label class="control-label">Campus Manager</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <p class="form-control-static"><a
                                                        href="{{ route('account_manager::account', [$user->account_manager_id]) }}">{{ $user->account_manager->getFullName() }}</a>
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                @if ($user->isType('sales_rep'))
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label class="control-label">School Year<br/>(Campus Ambassador)</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <p class="form-control-static">{{ school_year_text($user->school_year) }}</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label class="control-label">Venmo Username<br/>(Campus Ambassador)</label>
                                        </div>
                                        <div class="col-sm-8">
                                            <p class="form-control-static">{{ $user->venmo_username }}</p>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <div class="col-sm-4">
                                        <label class="control-label">Avatar</label>
                                    </div>
                                    <div class="col-sm-8">
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
                    <div class="title">
                        <h4>Addresses</h4>
                    </div>
                    @if ($user->addresses)
                        @foreach ($user->addresses as $address)
                            <div class="panel panel-default panel-box">
                                <div class="panel-body">
                                    <label class="control-label width-100">
                                        {{ $address->name }}
                                        @if ($user->address_id == $address->id)
                                            <strong class="pull-right">(Shipping Address)</strong>
                                        @endif
                                    </label><br/>
                                    <span>{{ $address->line1 }}</span><br/>
                                    @if ($address->line2)
                                        <span>{{ $address->line2 }}</span><br/>
                                    @endif
                                    <span>{{ $address->city }}
                                        , {{ $address->state }} {{ $address->zip_code }}</span><br/>
                                    <span>{{ country_name($address->country) }}</span>
                                </div>
                            </div>
                        @endforeach
                    @else
                        No addresses
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="title">
                        <h4>Campaigns</h4>
                    </div>
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
                                        @if ($entry->designer)
                                            <a href="{{ route('admin::user::read', [$entry->designer->id]) }}">{{ $entry->designer->getFullName() }}</a>
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
                    <div class="title margin-top">
                        <h4>Orders</h4>
                    </div>
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
@endsection
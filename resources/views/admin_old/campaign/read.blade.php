@extends ('admin_old.admin')

@section ('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Campaign Details</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    General Information
                    <a href="{{ route('admin::campaign::update_general', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">#</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ campaign_state_caption($campaign->state) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Requested Date</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->date ? $campaign->date->format('m/d/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Close Date</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->close_date ? $campaign->close_date->format('m/d/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Flexible Date</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->flexible }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Scheduled Date</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->scheduled_date ? $campaign->scheduled_date->format('m/d/Y') : 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Promo Code</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->promo_code ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Estimated Quantity</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->estimated_quantity }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Design Type</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->artwork_request->design_type == 'embroidery' ? 'Embroidery' : ($campaign->artwork_request->design_type == 'screen' ? 'Screenprint' : $campaign->artwork_request->design_type) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Budget</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->budget == 'yes' ? budget_caption($campaign->budget_range) : 'no' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Reminders</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->reminders }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Fulfillment Notes</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($campaign->fulfillment_notes)
                                        {!! bbcode($campaign->fulfillment_notes) !!}
                                    @else
                                        N/A
                                    @endif </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Actors
                    <a href="{{ route('admin::campaign::update_actors', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">User</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($campaign->user)
                                        <a href="{{ route('admin::user::read', [$campaign->user_id]) }}">{{ $campaign->user->getFullName() }}</a>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Designer</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($campaign->artwork_request->designer)
                                        <a href="{{ route('admin::user::read', [$campaign->artwork_request->designer_id]) }}">{{ $campaign->artwork_request->designer->getFullName() }}</a>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Decorator</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">
                                    @if ($campaign->decorator)
                                        <a href="{{ route('admin::user::read', [$campaign->decorator->id]) }}">{{ $campaign->decorator->getFullName() }}</a>
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Proofs
                    <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Design Hours</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ to_hours($campaign->artwork_request->design_minutes) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Hourly Rate</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">${{ $campaign->artwork_request->hourly_rate }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Proofs</label>
                            </div>
                            <div class="col-sm-9">
                                {{--@foreach ($campaign->proofs as $proof)--}}
                                    {{--@if ($campaign->getProofEntry($i))--}}
                                        {{--<img src="{{ route('system::image', [$proof->file_id]) }}"--}}
                                             {{--class="image-thumbnail"/>--}}
                                    {{--@endif--}}
                                {{--@endforeach--}}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Revision Text</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->revision_text }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Products
                    <a href="{{ route('admin::campaign::update_products', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-12">
                                @foreach ($campaign->product_colors as $productColor)
                                    <div>
                                        <label>{{ $productColor->product->name }} - {{ $productColor->name }}</label><br/>
                                        <img style="max-width: 200px;" src="{{ route('system::image', [$productColor->image_id]) }}"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Contact Information
                    <a href="{{ route('admin::campaign::update_contact', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">First Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->contact_first_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Last Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->contact_last_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Email</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->contact_email }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Phone</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->contact_phone }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">School</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->contact_school }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Chapter</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->contact_chapter }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping Information
                    <a href="{{ route('admin::campaign::update_shipping', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->address_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Line 1</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->address_line1 }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Line 2</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->address_line2 }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">City</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->address_city }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">State</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->address_state }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Zip Code</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->address_zip_code }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Country</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->address_country }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Shipping Types
                    <a href="{{ route('admin::campaign::update_shipping', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Group</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->shipping_group ? 'Enabled' : 'Disabled' }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Individual</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->shipping_individual?'Enabled' : 'Disabled' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Quote
                    <a href="{{ route('admin::campaign::update_quote', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Unit Cost</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ quote_range($campaign->quote_low, $campaign->quote_high, $campaign->quote_final) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Front
                    <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->artwork_request->print_front ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        @if ($campaign->artwork_request->print_front)
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Colors</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_front_colors }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_front_description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Pocket
                    <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->artwork_request->print_pocket ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        @if ($campaign->artwork_request->print_pocket)
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Colors</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_pocket_colors }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_pocket_description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Back
                    <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->artwork_request->print_back ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        @if ($campaign->artwork_request->print_back)
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Colors</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_back_colors }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_back_description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Printing - Sleeves
                    <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-default">Edit</a>
                </div>
                <div class="panel-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <div class="col-sm-3">
                                <label class="control-label">Enabled</label>
                            </div>
                            <div class="col-sm-9">
                                <p class="form-control-static">{{ $campaign->artwork_request->print_sleeve ? 'Yes' : 'No' }}</p>
                            </div>
                        </div>
                        @if ($campaign->artwork_request->print_sleeve)
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Sleeve</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_sleeve_preferred }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Colors</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_sleeve_colors }}</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <label class="control-label">Description</label>
                                </div>
                                <div class="col-sm-9">
                                    <p class="form-control-static">{{ $campaign->artwork_request->print_sleeve_description }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="table-responsive table-bordered margin-bottom">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Last Updated</th>
                        <th>State</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($campaign->orders as $entry)
                        <tr>
                            <td>{{ $entry->id }}</td>
                            <td><a href="{{ route('admin::order::read', [$entry->id]) }}">{{ $entry->payment_type }}
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
    <div class="row">
        <div class="col-sm-12">
            <div class=" action-area pull-right">
                <a href="{{ route('admin::campaign::list') }}" class="btn btn-default">Back</a>
            </div>
        </div>
    </div>
@endsection
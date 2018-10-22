@extends ('admin.layouts.admin')

@section ('content')
    <h1 class="page-header mb-4 pb-3 border-bottom">Campaign Details</h1>
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="home" aria-selected="true">General Information</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="design-tab" data-toggle="tab" href="#design" role="tab" aria-controls="profile" aria-selected="false">Design & Files</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="orders-tab" data-toggle="tab" href="#orders" role="tab" aria-controls="contact" aria-selected="false">Orders</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade p-3 show active" id="general" role="tabpanel" aria-labelledby="general-tab">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            General Information
                            <a href="{{ route('admin::campaign::update_general', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Id</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->id }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Name</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->name }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">State</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ campaign_state_caption($campaign->state)  }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Requested Date</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->date ? $campaign->date->format('m/d/Y') : 'N/A' }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Close Date</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->close_date ? $campaign->close_date->format('m/d/Y') : 'N/A' }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Flexible Date</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->flexible }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Scheduled Date</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->scheduled_date ? $campaign->scheduled_date->format('m/d/Y') : 'N/A' }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Promo Code</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->promo_code ?? 'N/A' }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Estimated Quantity</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->estimated_quantity }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Design Type</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->design_type == 'embroidery' ? 'Embroidery' : ($campaign->artwork_request->design_type == 'screen' ? 'Screenprint' : $campaign->artwork_request->design_type) }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Budget</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->budget == 'yes' ? budget_caption($campaign->budget_range) : 'no' }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Reminders</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->reminders }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Fulfillment Notes</label>
                                <div class="col-12 col-sm-7 col-form-label">
                                    @if ($campaign->fulfillment_notes)
                                        {!! bbcode($campaign->fulfillment_notes) !!}
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Actors
                            <a href="{{ route('admin::campaign::update_actors', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">User</label>
                                <div class="col-12 col-sm-7 col-form-label">
                                    @if ($campaign->user)
                                        <a href="{{ route('admin::user::read', [$campaign->user_id]) }}">{{ $campaign->user->getFullName() }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Designer</label>
                                <div class="col-12 col-sm-7 col-form-label">
                                    @if ($campaign->artwork_request->designer)
                                        <a href="{{ route('admin::user::read', [$campaign->artwork_request->designer_id]) }}">{{ $campaign->artwork_request->designer->getFullName() }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Decorator</label>
                                <div class="col-12 col-sm-7 col-form-label">
                                    @if ($campaign->decorator)
                                        <a href="{{ route('admin::user::read', [$campaign->decorator->id]) }}">{{ $campaign->decorator->getFullName() }}</a>
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Contact Information
                            <a href="{{ route('admin::campaign::update_contact', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">First Name</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->contact_first_name }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Last Name</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->contact_last_name }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Email</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->contact_email }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Phone</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->contact_phone }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">School</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->contact_school }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Chapter</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->contact_chapter }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Shipping Information
                            <a href="{{ route('admin::campaign::update_shipping', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Name</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->address_name }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Line 1</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->address_line1 }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Line 2</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->address_line2 }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">City</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->address_city }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">State</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->address_state }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Zip Code</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->address_zip_code }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Country</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->address_country }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Shipping Types
                            <a href="{{ route('admin::campaign::update_shipping_types', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Group</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->shipping_group ? 'Enabled' : 'Disabled' }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Individual</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->shipping_individual?'Enabled' : 'Disabled' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Products
                            <a href="{{ route('admin::campaign::update_products', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="card-body">
                            @forelse ($campaign->product_colors as $productColor)
                                <div class="form-group row mb-5">
                                    <label class="col-12 text-center font-weight-semi-bold">{{ $productColor->product->name }} - {{ $productColor->name }}</label>
                                    <div class="col-12 text-center"><img style="max-width: 200px;" src="{{ route('system::image', [$productColor->image_id]) }}"/></div>
                                </div>
                            @empty
                                <p>No Quotes</p>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Quotes
                            <a href="{{ route('admin::campaign::update_quote', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="card-body">
                            @forelse ($campaign->quotes as $quote)
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">{{ $quote->product->name }}</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ quote_range($quote->quote_low * 1.07, $quote->quote_high * 1.07, $quote->quote_final * 1.07) }}</div>
                                </div>
                            @empty
                                <p>No Quotes</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-3" id="design" role="tabpanel" aria-labelledby="design-tab">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Artwork
                            <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Design Hours</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ to_hours($campaign->artwork_request->design_minutes) }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Hourly Rate</label>
                                <div class="col-12 col-sm-7 col-form-label">${{ $campaign->artwork_request->hourly_rate }}</div>
                            </div>
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Revision Text</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->revision_text }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Printing - Front
                            <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Enabled</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_front ? 'Yes' : 'No' }}</div>
                            </div>
                            @if ($campaign->artwork_request->print_front)
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Colors</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_front_colors }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_front_description }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Printing - Pocket
                            <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Enabled</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_pocket ? 'Yes' : 'No' }}</div>
                            </div>
                            @if ($campaign->artwork_request->print_pocket)
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Colors</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_pocket_colors }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_pocket_description }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Printing - Back
                            <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Enabled</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_back ? 'Yes' : 'No' }}</div>
                            </div>
                            @if ($campaign->artwork_request->print_back)
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Colors</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_back_colors }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_back_description }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card mb-3">
                        <div class="card-header text-lg">
                            Printing - Sleeves
                            <a href="{{ route('admin::campaign::update_artwork_request', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <label class="col-12 col-sm-5 col-form-label text-right">Enabled</label>
                                <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_sleeve ? 'Yes' : 'No' }}</div>
                            </div>
                            @if ($campaign->artwork_request->print_sleeve)
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Sleeve</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_sleeve_preferred }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Colors</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_sleeve_colors }}</div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-12 col-sm-5 col-form-label text-right">Description</label>
                                    <div class="col-12 col-sm-7 col-form-label">{{ $campaign->artwork_request->print_sleeve_description }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <h1 class="page-header mb-4 pb-3 border-bottom">Proofs</h1>
                    <?php $products = product_color_products($campaign->product_colors) ?>
                    @foreach ($products as $product)
                        @foreach ($product->campaign_colors as $color)
                            <div class="card mb-3">
                                <div class="card-header text-lg">
                                    {{ $product->name }} - {{ $color->name }}
                                    <a href="{{ route('admin::campaign::update_proofs', [$campaign->id]) }}" class="btn btn-secondary float-right">Edit</a>
                                </div>
                                <div class="card-body">
                                    <div id="carousel-proofs-{{ $product->id }}-{{ $color->id }}" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @foreach ($campaign->artwork_request->getProofsFromProductColor($color->id) as $proof)
                                                <li data-target="#carousel-proofs-{{ $product->id }}-{{ $color->id }}" data-slide-to="{{ $loop->index }}"
                                                    class="{{ $loop->index == 0 ? 'active' : '' }}"></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach ($campaign->artwork_request->getProofsFromProductColor($color->id) as $proof)
                                                <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                                    <img class="d-block w-100" src="{{ route('system::image', [$proof->file_id]) }}" alt="{{ $product->name }} - {{ $color->name }}">
                                                </div>
                                            @endforeach
                                        </div>
                                        <a class="carousel-control-prev" href="#carousel-proofs-{{ $product->id }}-{{ $color->id }}" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Previous</span>
                                        </a>
                                        <a class="carousel-control-next" href="#carousel-proofs-{{ $product->id }}-{{ $color->id }}" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Next</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-3" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <div class="card mb-3">
                <div class="card-header text-lg">
                    Orders
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>Qty</th>
                                <th>Amount</th>
                                <th>State</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $quantity = 0; $total = 0; ?>
                            @foreach ($campaign->orders as $entry)
                                <tr>
                                    <td><a href="{{ route('admin::order::read', [$entry->id]) }}">{{ $entry->id }}</a></td>
                                    <td>{{ $entry->contact_email }}</td>
                                    <td>{{ $entry->quantity }}</td>
                                    <td>{{ money($entry->total) }}</td>
                                    <td>{{ $entry->state }}</td>
                                    <?php $quantity += $entry->quantity; $total += $entry->total; ?>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2"><strong>Total</strong></td>
                                <td>{{ $quantity }}</td>
                                <td>{{ money($total) }}</td>
                                <td>&nbsp;</td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@append

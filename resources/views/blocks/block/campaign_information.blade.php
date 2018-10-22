<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-price"></i><span class="icon-text">Campaign Info</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="order-information-box">
            <table class="order-information-box-list">
                <tr>
                    <td>Created By<strong
                                class="green-text bold-text">{{ $campaign->user ? $campaign->user->getFullName(true) : 'N/A' }}</strong>
                    </td>
                    <td>Designer<strong
                                class="red-text bold-text">{{ $campaign->artwork_request->designer ? $campaign->artwork_request->designer->getFullName() : 'N/A' }}</strong>
                    </td>
                    <td>University<br/>Chapter<strong
                                class="black-text bold-text">{{ $campaign->contact_school ? $campaign->contact_school:'' }}
                            <br/>{{ $campaign->contact_chapter ? $campaign->contact_chapter : '' }}</strong></td>
                    <td>Order Ship date is<strong
                                class="blue-text">{{ $campaign->flexible=='yes'?'Flexible Within Timeframe':'Must be delivered in exact date' }}</strong>
                    </td>
                </tr>
                <tr>
                    <td>
                        @if($showPaymentType)
                            Payment Type <strong
                                    class="blue-text">{{  ($campaign->payment_type)? $campaign->payment_type : 'N/A'  }}</strong>
                        @endif

                    </td>
                    <td>Estimated Quantity<strong class="black-text">{{ $campaign->estimated_quantity }}</strong></td>
                    <td>Delivery Due Date<strong
                                class="text-nowrap bold-text">{{ $campaign->date ? $campaign->date->format('m/d/Y') : 'N/A' }}</strong>
                    </td>

                    <td>Sizes collected by Date<strong
                                class="text-nowrap bold-text">{{ $campaign->sizes_collected_date ? date('m/d/Y', strtotime($campaign->sizes_collected_date)) : 'N/A' }}</strong>
                    </td>

                </tr>
            </table>
            <div class="collapse-container">
                <a class="collapse-button" role="button" data-toggle="collapse" href="#collapse-content"
                   aria-expanded="true" aria-controls="collapse-content">
                    <span class="collapse-text">Show less</span>
                    <span class="pull-right icon-arrow"></span>
                </a>
                <div class="collapse-content" id="collapse-content">
                    <ul class="order-information-box-details">
                        @if ($campaign->artwork_request->print_front)
                            <li>
                                <div class="detail-title">
                                    <h4 class="pull-left">Front of Shirt</h4>
                                    <p class="pull-right"># of colors:
                                        <span>{{ $campaign->artwork_request->print_front_colors }}</span>
                                    </p>
                                </div>
                                <p>{!! process_text($campaign->artwork_request->print_front_description) !!}</p>
                            </li>
                        @endif
                        @if ($campaign->artwork_request->print_pocket)
                            <li>
                                <div class="detail-title">
                                    <h4 class="pull-left">Pocket of Shirt</h4>
                                    <p class="pull-right"># of colors:
                                        <span>{{ $campaign->artwork_request->print_pocket_colors }}</span>
                                    </p>
                                </div>
                                <p>{!! process_text($campaign->artwork_request->print_pocket_description) !!}</p>
                            </li>
                        @endif
                        @if ($campaign->artwork_request->print_back)
                            <li>
                                <div class="detail-title">
                                    <h4 class="pull-left">Back of Shirt</h4>
                                    <p class="pull-right"># of colors:
                                        <span>{{ $campaign->artwork_request->print_back_colors }}</span>
                                    </p>
                                </div>
                                <p>{!! process_text($campaign->artwork_request->print_back_description) !!}</p>
                            </li>
                        @endif
                        @if ($campaign->artwork_request->print_sleeve)
                            <li>
                                <div class="detail-title">
                                    <h4 class="pull-left">{{ $campaign->artwork_request->print_sleeve_preferred=='left'?'Left':'' }}{{ $campaign->artwork_request->print_sleeve_preferred=='right'?'Right':'' }}{{ $campaign->artwork_request->print_sleeve_preferred=='both'?'Both':'' }}
                                        Sleeve{{ $campaign->artwork_request->print_sleeve_preferred=='both'?'s':'' }} of
                                        Shirt</h4>
                                    <p class="pull-right"># of colors:
                                        <span>{{ $campaign->artwork_request->print_sleeve_colors }}</span>
                                    </p>
                                </div>
                                <p>{!! process_text($campaign->artwork_request->print_sleeve_description) !!}</p>
                            </li>
                        @endif
                        @if (isset($supplier) && $supplier)
                            @if($campaign->product_colors->first()->product->suggested_supplier)
                                <li>
                                    <div class="detail-title">
                                        <h4 class="pull-left">Suggested Suppliers</h4>
                                    </div>
                                    @foreach (product_color_products($campaign->product_colors) as $product)
                                        @if($product->suggested_supplier)
                                            <p>{{ $product->name }}{!! bbcode($product->suggested_supplier) !!}</p>
                                        @endif
                                    @endforeach
                                </li>
                            @endif
                            @if (isset($fulfillmentIntructions) && $fulfillmentIntructions)
                                @foreach (product_color_products($campaign->product_colors) as $product)
                                    @if ($product->fulfillment_instructions)
                                        <li>
                                            <div class="detail-title">
                                                <h4 class="pull-left">Fulfillment Instructions ({{ $product->name }}
                                                    )</h4>
                                            </div>
                                            <p>{!! bbcode($product->fulfillment_instructions) !!}</p>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endif
                        @if (isset($designInstructions) && $designInstructions)
                            @foreach (product_color_products($campaign->product_colors) as $product)
                                @if ($product->designer_instructions)
                                    <li>
                                        <div class="detail-title">
                                            <h4 class="pull-left">Design Instructions ({{ $product->name }})</h4>
                                        </div>
                                        <p>{!! bbcode($product->designer_instructions) !!}</p>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                        <li>
                            <div class="detail-title">
                                <h4 class="pull-left">Design Preference</h4>
                            </div>
                            <p>{{ design_style_preference_text($campaign->artwork_request->design_style_preference) }}</p>
                        </li>
                        @if($campaign->promo_code)
                            <li>
                                <div class="detail-title">
                                    <h4 class="pull-left">Promo Code</h4>

                                </div>
                                <p>{!! bbcode($campaign->promo_code) !!}</p>
                            </li>
                        @endif
                    </ul>
                    @if (count($campaign->getCurrentArtwork()->images) > 0)
                        <div class="order-information-box-attachments">
                            <h4 class="pull-left">Reference Images</h4>
                            <ul>
                                @foreach ($campaign->getCurrentArtwork()->images as $imageEntry)
                                    <li>
                                        @if (is_image($imageEntry->file->name))
                                            <a href="{{ route('system::image', [$imageEntry->file->id]) }}"
                                               class="fancybox-image" title="{{ $imageEntry->file->name }}">
                                                <div class="image-thumbnail"><img
                                                            src="{{ route('system::image', [$imageEntry->file->id]) }}"
                                                            alt="{{ $imageEntry->file->name }}"></div>
                                                <span class="image-thumbnail-name">{{ $imageEntry->file->name }}</span>
                                            </a>
                                        @else

                                            <a href="{{ route('system::file', [$imageEntry->file->id]) }}"
                                               title="{{ $imageEntry->file->name }}">
                                                <span class="image-thumbnail-name">{{ $imageEntry->file->name }}</span>
                                            </a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section ('include')
    <?php register_js(static_asset('js/jquery.mCustomScrollbar.concat.min.js')) ?>
    <?php register_css(static_asset('css/jquery.mCustomScrollbar.css')) ?>
@append

@section ('javascript')
    <script>
        $('.order-information-box').on('click', '.collapse-button', function (event) {
            event.preventDefault();
            var that = this;
            var container = $(this).closest('.collapse-container');
            if (container.hasClass('collapsed')) {
                $(that).find('.collapse-text').text('Show less');
                container.removeClass('collapsed');
                container.find('.collapse-content').animate({
                    height: 'auto'
                }, 0, 'swing');
            } else {
                container.find('.collapse-content').animate({
                    height: 0
                }, 0, 'swing', function () {
                    $(that).find('.collapse-text').text('Show more');
                    container.addClass('collapsed');
                });
            }
            return false;
        });
    </script>
    <script type="text/javascript">
        $(".fancybox-image").click(function (event) {
            event.preventDefault();
            $.fancybox({
                width: '550px',
                height: 'auto',
                autoSize: false,
                href: $(this).attr('href'),
                scrolling: 'no',
                'titlePosition': 'inside',
                'overlayShow': true
            });
            return false;
        });
    </script>
@append
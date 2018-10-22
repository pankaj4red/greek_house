@extends('v3.layouts.app')

@section('title', $campaign->name)

@section('content')
    <?php $productProofInformation = campaign_product_proof_information($campaign, null) ?>
    <div class="container mt-5" id="checkout" data-proofs="{{ json_encode($productProofInformation) }}" {!! $productColorToSelect ? 'data-selected-color="' . $productColorToSelect->id . '"' : '' !!}>
        <div class="checkout-details">
            <div class="row">
                <div class="col-12 col-md-7 pb-3">
                    <div class="row">
                        <div class="col-12 col-md-2">
                            <div class="card d-block d-md-none">
                                <div class="card-header border-bottom-0">
                                    {{ $campaign->name }}
                                </div>
                            </div>
                            @foreach ($productProofInformation as $product)
                                <?php $loopVariable = $loop ?>
                                @foreach ($product->colors as $color)
                                    <ul class="image-pick-list vertical"
                                        v-if="product == {{ $product->id }} && color == {{ $color->id }}" {{ $loopVariable->index != 0 || $loop->index != 0 ? 'v-cloak' : '' }}>
                                        @foreach ($color->proofs as $proof)
                                            <li v-bind:class="{ active: proof == {{ $proof->id }} }">
                                                <a href="javascript: void(0)" @click="selectProof({{ $proof->id }})">
                                                    <span>
                                                        <img src="{{ $proof->image }}"/>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            @endforeach
                        </div>
                        <div class="col-12 col-md-10">
                            @foreach ($productProofInformation as $product)
                                <?php $loopVariable = $loop ?>
                                @foreach ($product->colors as $color)
                                    <div id="carousel-{{ $product->id }}-{{ $color->id }}"
                                         v-if="product == {{ $product->id }} && color == {{ $color->id }}" {{ $loopVariable->index != 0 || $loop->index != 0 ? 'v-cloak' : '' }}>
                                        <div class="carousel slide" data-interval="false">
                                            <div class="carousel-inner">
                                                @foreach ($color->proofs as $proof)
                                                    <div class="carousel-item {{ $loop->index == 0 ? 'active' : '' }}">
                                                        <img class="d-block w-100" src="{{ $proof->image }}" alt="{{ $product->name }} {{ $color->name }} {{ $loop->index + 1 }}">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-5">
                    <div class="card">
                        <div class="card-header d-none d-md-block">
                            {{ $campaign->name }}
                        </div>
                        <div class="card-body">
                            <div class="campaign-progress mt-3">
                                <div class="campaign-progress-bar campaign-progress-mt-lg">
                                    <div class="progress-success" style="width: {{ $campaign->getGoalPercentage() }}%;"></div>
                                    <div class="progress-point min">
                                        <div class="point-dash"></div>
                                        <div class="point-title point-title-top-lg" data-mob="Min {{ $campaign->getMinimumQuantity() }}">Minimum at: {{ $campaign->getMinimumQuantity() }}</div>
                                    </div>
                                    <div class="progress-point best">
                                        <div class="point-dash"></div>
                                        <div class="point-title" data-mob="Best {{ $campaign->getMaximumQuantity() }}">Best price at: {{ $campaign->getMaximumQuantity() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p class="text-center">Time Left to Buy</p>
                                <div id="countdown" data-days="{{ $days }}" data-hours="{{ $hours }}" data-minutes="{{ $minutes }}" data-seconds="{{ $seconds }}">
                                    <div class="countdown-item" id="countdown-days">
                                        <div class="countdown-item-inner">
                                            <div class="countdown-item-value" v-text="days">{{ $days }}</div>
                                            <div class="countdown-item-label">Day{{ $days > 1 ? 's' : '' }}</div>
                                        </div>
                                    </div>
                                    <div class="countdown-item" id="countdown-hours">
                                        <div class="countdown-item-inner">
                                            <div class="countdown-item-value" v-text="hours">{{ $hours }}</div>
                                            <div class="countdown-item-label">Hour{{ $hours > 1 ? 's' : '' }}</div>
                                        </div>
                                    </div>
                                    <div class="countdown-item" id="countdown-minutes">
                                        <div class="countdown-item-inner">
                                            <div class="countdown-item-value" v-text="minutes">{{ $minutes }}</div>
                                            <div class="countdown-item-label">Minute{{ $minutes > 1 ? 's' : '' }}</div>
                                        </div>
                                    </div>
                                    <div class="countdown-item" id="countdown-seconds">
                                        <div class="countdown-item-inner">
                                            <div class="countdown-item-value" v-text="seconds">{{ $seconds }}</div>
                                            <div class="countdown-item-label">Second{{ $seconds > 1 ? 's' : '' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3">Available Products</p>
                            <div class="form-group">
                                <select class="form-control" title="Available Products" v-model="product" v-on:change="selectProduct(product)">
                                    @foreach ($productProofInformation as $product)
                                        <option value="{{ $product->id }}">
                                            {{ $product->name }} -
                                            @if ($campaign->quotes->where('product_id', $product->id)->first())
                                                {{ quote_range($campaign->quotes->where('product_id', $product->id)->first()->quote_low * 1.07, $campaign->quotes->where('product_id', $product->id)->first()->quote_high * 1.07, $campaign->quotes->where('product_id', $product->id)->first()->quote_final * 1.07) }}
                                            @else
                                                N/A
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mt-3">
                                <ul class="image-pick-list">
                                    @foreach ($productProofInformation as $product)
                                        <li v-bind:class="{ active: product == {{ $product->id }} }">
                                            <a href="javascript: void(0)" @click="selectProduct({{ $product->id }})">
                                            <span>
                                                <img src="{{ isset($product->colors[0]->proofs[0]->image) ? $product->colors[0]->proofs[0]->image : static_asset('images/not_available.png') }}"/>
                                            </span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="mt-3">
                                <p>Colors</p>
                                @foreach ($productProofInformation as $product)
                                    <ul class="color-pick-list" v-if="product == {{ $product->id }}">
                                        @foreach ($product->colors as $color)
                                            <li v-bind:class="{ active: color == {{ $color->id }} }">
                                                <a href="javascript: void(0)" @click="selectColor({{ $color->id }})">
                                                    <span>
                                                        <img src="{{ $color->image }}"/>
                                                    </span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                            <div class="mt-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#add-to-cart">Add to Cart</button>
                                </div>
                            </div>
                            <div class="mt-3">
                                Share this product
                                <div class="product__share">
                                    <h6 class="gh-subtitle small">Share this product</h6>
                                    <div class="share-block">
                                        <a href="#" class="share fb">
                                            <i class="fa fa-facebook" aria-hidden="true"></i> Share
                                        </a>
                                        <a href="#" class="share campaign">
                                            <i class="fa fa-link" aria-hidden="true"></i> Share the link
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p><strong>Shipping Info</strong></p>
                                <ul class="list-unstyled">
                                    <li>- Orders are printed and shipped after the time expires on the campaign.</li>
                                    <li>- You can expect your package to arrive 10-14 business days after the campaign ends unless specified</li>
                                </ul>
                            </div>
                            <div class="mt-4">
                                <p><strong>Return Policy</strong></p>
                                <ul class="list-unstyled">
                                    <li>- This item is custom made to order and cannot be returned. If there is a printing or manufacturing issue, please email <a
                                                href="mailto: support@greekhouse.org">support@greekhouse.org</a> with further details.
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if ($campaigns->count() > 0)
        <div class="container text-center mt-5 pt-5">
            <h2 class="h3 title-blue mb-5">More Campaigns For Your Chapter</h2>
            <div class="row">
                <?php $count = 0; ?>
                @foreach ($campaigns as $storeCampaign)
                    @if ($storeCampaign->id == $campaign->id)
                        @continue
                    @endif
                    @foreach ($storeCampaign->product_colors as $productColor)
                        @if ($storeCampaign->artwork_request->getProofsFromProductColor($productColor->id)->count() > 0)
                            <div class="col-12 col-sm-3">
                                <a href="{{ route('custom_store::details', [product_to_description($storeCampaign->id, $storeCampaign->name), $productColor->id]) }}" class="text-no-underline">
                                    <img class="d-block w-100 image-hover-effect"
                                         src="{{ route('system::image', [$storeCampaign->artwork_request->getProofsFromProductColor($productColor->id)->first()->file_id]) }}"/>
                                    <p class="mt-3 mb-0 sub-title">{{ $storeCampaign->name }}</p>
                                    <p class="mt-0 mb-4 color-blue">{{ money($storeCampaign->quotes->where('product_id', $productColor->product_id)->first()->quote_high * 1.07) }}</p>
                                </a>
                            </div>
                            <?php $count++ ?>
                        @endif
                        @if ($count >= 8)
                            @break
                        @endif
                    @endforeach
                    @if ($count >= 8)
                        @break
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    <?php $productPriceInformation = campaign_product_prices_information($campaign, null); ?>
    <div class="modal fade" id="add-to-cart" tabindex="-1" role="dialog" aria-labelledby="add-to-cart-label" aria-hidden="true"
         data-products="{{ json_encode($productPriceInformation) }}" {!! $productColorToSelect ? 'data-selected-color="' . $productColorToSelect->id . '"' : '' !!}>
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{ Form::open() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="add-to-cart-label">Your Order</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th scope="col" class="border-top-0" style="width: 60px"></th>
                                <th scope="col" class="border-top-0" style="width: 80px">Qty</th>
                                <th scope="col" class="border-top-0" style="width: 80px">Size</th>
                                <th scope="col" class="border-top-0">Style</th>
                                <th scope="col" class="border-top-0" style="width: 80px">Price</th>
                            </tr>
                            </thead>
                            <tbody ref="lineList"></tbody>
                        </table>
                    </div>
                    <div>
                        <a href="javascript: void(0)" v-on:click="addLine($event)">+ Add another style or color</a>
                    </div>
                    <div class="mt-3 text-right">
                        <button type="submit" class="btn btn-success">Add to Cart</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <script type="text/x-template" id="add-to-cart-line-template">
            <tr v-bind:data-product-color-id="colorId" class="add-to-cart-line">
                <td class="align-middle align-content-center"><img v-bind:src="image" class="add-to-cart-thumbnail" style="width: 45px; height: 45px"/></td>
                <td><input type="text" class="form-control form-control-sm" v-model="quantity" title="Quantity" name="quantity[]"/></td>
                <td>
                    <select class="form-control form-control-sm" name="size[]" title="Sizes" v-model="sizeId" @change="changeSize($event)">
                        <option v-for="size in sizes" v-bind:value="size.value" v-html="size.text"></option>
                    </select>
                </td>
                <td>
                    <select class="form-control form-control-sm" name="color[]" title="Colors" v-model="colorId" @change="changeColor($event)">
                        <option v-for="color in colors" v-bind:value="color.value" v-html="color.text"></option>
                    </select>
                </td>
                <td class="align-middle text-center">
                    <span class="text-sm" v-text="price"></span><br/>
                    <a class="add-to-line-remove text-sm" href="javascript: void(0)" v-on:click="removeThisLine($event)" v-show="canRemoveLines()">[Remove]</a>
                </td>
            </tr>
        </script>
    </div>
    @include('v3.partials.expanded_footer')
@endsection

@section('javascript')
    <script src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5416f2ad4d856633"></script>
@append
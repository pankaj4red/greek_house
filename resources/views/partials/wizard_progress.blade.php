<div class="container">
    <div class="row list-tag-products">
        <div class="col-12">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li role="presentation" class="{{ Request::is('wizard/product*') ? 'active' : '' }} step-five tab-style-custom">
                    <a href="{{ route('wizard::product') . ($campaignLead->product_colors->count() > 0 ? '?c=' . $campaignLead->product_colors->first()->id : '') }}" class="tab-padding"><span class="number-glyph">1.</span> CHOOSE A PRODUCT</a>
                </li>
                <li role="presentation" class="{{ Request::is('wizard/design*') ? 'active' : '' }} step-five tab-style-custom">
                    @if ($campaignLead->product_colors->count() > 0)
                        <a href="{{ route('wizard::design') }}" class=""><span class="number-glyph">2.</span> DESIGN DESCRIPTION</a>
                    @else
                        <span class="tab-padding"><span class="number-glyph">2.</span> DESIGN DESCRIPTION</span>
                    @endif
                </li>
                <li role="presentation" class="{{ Request::is('wizard/order*') ? 'active' : '' }} step-five tab-style-custom">
                    @if ($campaignLead->name)
                        <a href="{{ route('wizard::order') }}" class=""><span class="number-glyph">3.</span> PRINT TYPE</a>
                    @else
                        <span class="tab-padding"><span class="number-glyph">3.</span> PRINT TYPE</span>
                    @endif
                </li>
                <li role="presentation" class="{{ Request::is('wizard/delivery*') ? 'active' : '' }} step-five tab-style-custom">
                    @if ($campaignLead->estimated_quantity)
                        <a href="{{ route('wizard::delivery') }}" class=""><span class="number-glyph">4.</span> DELIVERY</a>
                    @else
                        <span class="tab-padding"><span class="number-glyph">4.</span> DELIVERY</span>
                    @endif
                </li>
                <li role="presentation" class="{{ Request::is('wizard/review*') ? 'active' : '' }} step-five tab-style-custom">
                    @if ($campaignLead->flexible)
                        <a href="{{ route('wizard::review') }}" class=""><span class="number-glyph">5.</span> REVIEW</a>
                    @else
                        <span class="tab-padding"><span class="number-glyph">5.</span> REVIEW</span>
                    @endif
                </li>
            </ul>
        </div>
    </div><!-- end of the row list-tag-products -->
</div><!-- end of the container section -->
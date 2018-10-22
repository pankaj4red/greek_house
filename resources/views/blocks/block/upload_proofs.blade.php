<div class="panel panel-default panel-minimalistic">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-tshirt"></i><span class="icon-text">Upload Proofs</span></h3>
        @if ($edit)
            <a href="{{ $popupUrl }}" class="profile-edit ajax-popup order-detail-page" data-width="80%">EDIT</a>
        @endif
    </div>
    <div class="panel-body">
        <div class="order-proof-box">
            <table class="order-proof-box-list">
                <tr>
                    <td>Front Colors<strong class="">{{ $campaign->artwork_request->designer_colors_front }}</strong></td>
                    <td>Back Color<strong class="">{{ $campaign->artwork_request->designer_colors_back }}</strong></td>
                    <td>Left S. Colors<strong class="">{{ $campaign->artwork_request->designer_colors_sleeve_left }}</strong></td>
                    <td>Right S. Colors<strong class="">{{ $campaign->artwork_request->designer_colors_sleeve_right }}</strong></td>
                </tr>
                <tr>
                    <td colspan="2">Black Shirt<strong
                                class="black-text">{{ $campaign->artwork_request->designer_black_shirt?'Yes':'No' }}</strong></td>
                    <td colspan="2">Design Hours<strong
                                class="black-text design-hours">{{ to_hours($campaign->artwork_request->design_minutes) }}</strong></td>
                </tr>
            </table>
            <div class="collapse-container collapsed">
                <a class="collapse-button" role="button" data-toggle="collapse" href="#collapse-content-proof"
                   aria-expanded="false" aria-controls="collapse-content-proof">
                    <span class="collapse-text">Show more</span>
                    <span class="pull-right icon-arrow"></span>
                </a>
                <div class="collapse-content background-white" id="collapse-content-proof">
                    @if (count($campaign->getCurrentArtwork()->proofs) > 0)
                        <?php $images = []; ?>
                        @foreach ($campaign->getCurrentArtwork()->proofs as $proofEntry)
                            <?php /** @var \App\Models\ArtworkRequestFile $proofEntry */ $images[] = $proofEntry->file; ?>
                        @endforeach
                        @include('partials.slider', [
                            'watermark' => true,
                            'images' => $images, 'actionArea' => ''
                        ])
                    @else
                        <div class="no-content">
                            No Proofs were uploaded.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@section ('javascript')
    <script>
        $('.order-proof-box').on('click', '.collapse-button', function (event) {
            event.preventDefault();
            var that = this;
            var container = $(this).closest('.collapse-container');
            if (container.hasClass('collapsed')) {
                $(that).find('.collapse-text').text('Show less');
                container.removeClass('collapsed');
                container.find('.collapse-content').animate({
                    height: 'auto'
                }, 0, 'swing', function () {
                    $(this).css('height', 'auto');
                });
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
@append

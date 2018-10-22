<div class="panel panel-default panel-box">
    <div class="panel-heading">
        <h3 class="panel-title"><i class="icon icon-status"></i><span class="icon-text">Source Design</span></h3>
    </div>
    <div class="panel-body">
        <div class="colored-list">
            <div class="colored-item blue">
                <div class="colored-item-information">
                    <h5 class="colored-item-title">Design</h5>
                    <p class="colored-item-text"><a href="{{ route('home::design_gallery', [$campaign->source_design_id]) }}" target="_blank">{{ $campaign->source_design->name }}</a></p>
                </div>
            </div>
        </div>
        <h5 class="colored-item-title default-margin-top half-margin-bottom">Source Design Images</h5>
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="collapse-container collapsed">
                    <a class="collapse-button" role="button" data-toggle="collapse" href="#collapse-content-design"
                       aria-expanded="false" aria-controls="collapse-content">
                        <span class="collapse-text">Show more</span>
                        <span class="pull-right icon-arrow"></span>
                    </a>
                    <div class="collapse-content" id="collapse-content-design">
                        @foreach ($campaign->source_design->images as $image)
                            <a href="{{ route('system::image_download', [$image->file_id]) }}"><img src="{{ route('system::image', [$image->file_id]) }}" class="width-100 default-margin-bottom"/></a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section ('javascript')
    <script>
        $('#accordion').on('click', '.collapse-button', function (event) {
            event.preventDefault();
            var that = this;
            var container = $(this).closest('.collapse-container');
            if (container.hasClass('collapsed')) {
                $(that).find('.collapse-text').text('Show less');
                container.removeClass('collapsed');
                container.find('.collapse-content').animate({
                    height: 'auto'
                }, 0, 'swing', function() {
                    container.find('.collapse-content').css('height', 'auto');
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
